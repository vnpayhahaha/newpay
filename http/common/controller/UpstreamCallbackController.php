<?php

namespace http\common\controller;

use app\constants\CollectionOrder;
use app\constants\DisbursementOrder;
use app\constants\Tenant;
use app\constants\TransactionVoucher;
use app\controller\BasicController;
use app\lib\enum\ResultCode;
use app\model\ModelChannel;
use app\repository\ChannelCallbackRecordRepository;
use app\router\Annotations\GetMapping;
use app\router\Annotations\RequestMapping;
use app\router\Annotations\RestController;
use app\service\ChannelService;
use app\service\TransactionVoucherService;
use app\upstream\Handle\TransactionCollectionOrderFactory;
use app\upstream\Handle\TransactionDisbursementOrderFactory;
use Carbon\Carbon;
use DI\Attribute\Inject;
use support\Log;
use support\Request;
use support\Response;
use Webman\RateLimiter\Annotation\RateLimiter;
use Webman\RedisQueue\Redis;
use Webman\Route;

#[RestController("/callback")]
class UpstreamCallbackController extends BasicController
{

    #[Inject]
    protected ChannelService $channelService;

    #[Inject]
    protected TransactionVoucherService $transactionVoucherService;

    #[Inject]
    protected ChannelCallbackRecordRepository $callbackRecordRepository;

    #[RequestMapping(path: '/collection/{channel_code}/{channel_account_id}', methods: 'GET,POST'), RateLimiter(limit: 10)]
    public function collection_order(Request $request, string $channel_code, int $channel_account_id): Response
    {
        return $this->handleCallback($request, $channel_code, $channel_account_id, 'collection');
    }

    // 打款订单回调通知
    #[RequestMapping(path: '/disbursement/{channel_code}/{channel_account_id}', methods: 'GET,POST'), RateLimiter(limit: 10)]
    public function disbursement_order(Request $request, string $channel_code, int $channel_account_id): Response
    {
        return $this->handleCallback($request, $channel_code, $channel_account_id, 'disbursement');
    }

    #[GetMapping('/route')]
    public function routers(Request $request): Response
    {
        $routers = Route::getRoutes();
        var_dump($routers);
        return $this->success($routers);
    }

    /**
     * 统一处理回调逻辑
     */
    private function handleCallback(Request $request, string $channel_code, int $channel_account_id, string $callbackType): Response
    {
        $startTime = microtime(true);
        $params = $request->all();
        $callbackId = $this->generateCallbackId();

        Log::info("UpstreamCallbackController {$callbackType}订单回调", [
            'channel_code' => $channel_code,
            'params'       => $params
        ]);
        // 获取通道信息
        $modelChannel = $this->getChannelByCode($channel_code);
        if (!$modelChannel) {
            return $this->error(ResultCode::INVALID_CHANNEL);
        }
        $callbackRecord = $this->recordCallbackStart($request, $modelChannel, $callbackId, $callbackType);

        try {
            // 获取服务类名
            $className = $this->getServiceClassName($channel_code, $callbackType);
            if (!$className) {
                $this->updateCallbackRecord($callbackRecord->id, false, '无效的渠道代码', microtime(true) - $startTime);
                return $this->error(ResultCode::INVALID_CHANNEL);
            }

            // 获取服务实例并处理回调
            $service = $this->getServiceInstance($className);
            $result = $service->notify($request);
            if (!$result) {
                $this->updateCallbackRecord($callbackRecord->id, false, '无效的回调结果', microtime(true) - $startTime);
                return $this->error(ResultCode::FAIL);
            }

            // 处理回调结果
            return $this->processCallbackResult($result, $callbackRecord, $modelChannel, $channel_account_id, $callbackType, $service, $startTime);

        } catch (\Throwable $e) {
            Log::error("回调处理异常", [
                'channel_code'  => $channel_code,
                'callback_type' => $callbackType,
                'error'         => $e->getMessage(),
                'trace'         => $e->getTraceAsString()
            ]);

            $this->updateCallbackRecord($callbackRecord->id, false, '回调处理异常: ' . $e->getMessage(), microtime(true) - $startTime);

            // 尝试获取服务实例来返回失败响应
            try {
                $className = $this->getServiceClassName($channel_code, $callbackType);
                if ($className) {
                    $service = $this->getServiceInstance($className);
                    return $service->notifyReturn(false);
                }
            } catch (\Throwable $e) {
                // 忽略获取服务实例时的异常
                Log::error("获取服务实例异常", [
                    'channel_code'  => $channel_code,
                    'callback_type' => $callbackType,
                    'error'         => $e->getMessage(),
                    'trace'         => $e->getTraceAsString()
                ]);
            }

            return $this->error(ResultCode::FAIL);
        }
    }

    /**
     * 生成回调ID
     */
    private function generateCallbackId(): string
    {
        return uniqid('callback_', true) . '_' . time();
    }

    /**
     * 获取服务类名
     */
    private function getServiceClassName(string $channelCode, string $callbackType): ?string
    {
        $options = match ($callbackType) {
            'collection' => Tenant::$upstream_options,
            'disbursement' => Tenant::$upstream_disbursement_options,
            default => []
        };

        $className = $options[$channelCode] ?? '';
        return $className && class_exists($className) ? $className : null;
    }

    /**
     * 根据渠道代码获取通道信息
     */
    private function getChannelByCode(string $channelCode): ?ModelChannel
    {
        return $this->channelService->repository->getQuery()
            ->where('channel_code', $channelCode)
            ->first();
    }

    /**
     * 获取服务实例
     */
    private function getServiceInstance(string $className): object
    {
        // 检查是否为收款服务
        if (in_array($className, Tenant::$upstream_options)) {
            return TransactionCollectionOrderFactory::getInstance($className);
        }

        // 检查是否为打款服务
        if (in_array($className, Tenant::$upstream_disbursement_options)) {
            return TransactionDisbursementOrderFactory::getInstance($className);
        }

        throw new \InvalidArgumentException("Unsupported service class: {$className}");
    }

    /**
     * 处理回调结果
     */
    private function processCallbackResult(
        array  $result,
        object $callbackRecord,
        object $modelChannel,
        int    $channelAccountId,
        string $callbackType,
        object $service,
        float  $startTime
    ): Response
    {
        if (!($result['ok'] ?? false)) {
            $this->updateCallbackRecord($callbackRecord->id, false, '上游回调返回失败状态', microtime(true) - $startTime);
            return $service->notifyReturn(false);
        }

        // 提取交易凭证信息
        $voucherInfo = $this->extractTransactionVoucher($result['data'] ?? []);
        if (!$voucherInfo) {
            $this->updateCallbackRecord($callbackRecord->id, false, '缺少必要的交易凭证信息', microtime(true) - $startTime);
            return $service->notifyReturn(false);
        }

        // 检查是否已存在相同的交易凭证
        if ($this->isTransactionVoucherExists($voucherInfo['type'], $voucherInfo['voucher'])) {
            $this->updateCallbackRecord($callbackRecord->id, true, '交易凭证已存在，重复通知', microtime(true) - $startTime);
            return $service->notifyReturn(true);
        }

        // 根据回调类型处理业务逻辑
        $success = match ($callbackType) {
            'collection' => $this->handleCollectionCallback($result, $modelChannel, $channelAccountId),
            'disbursement' => $this->handleDisbursementCallback($result),
            default => false
        };

        if (!$success) {
            $this->updateCallbackRecord($callbackRecord->id, false, '队列推送失败', microtime(true) - $startTime);
            return $service->notifyReturn(false);
        }

        $this->updateCallbackRecord($callbackRecord->id, true, "{$callbackType}回调处理成功", microtime(true) - $startTime);
        return $service->notifyReturn(true);
    }

    /**
     * 提取交易凭证信息
     */
    private function extractTransactionVoucher(array $data): ?array
    {
        if (isset($data['_utr']) && filled($data['_utr'])) {
            return [
                'type'    => TransactionVoucher::TRANSACTION_VOUCHER_TYPE_UTR,
                'voucher' => $data['_utr']
            ];
        }

        if (isset($data['_upstream_order_no']) && filled($data['_upstream_order_no'])) {
            return [
                'type'    => TransactionVoucher::TRANSACTION_VOUCHER_TYPE_UPSTREAM_ORDER_NO,
                'voucher' => $data['_upstream_order_no']
            ];
        }

        if (isset($data['_platform_order_no']) && filled($data['_platform_order_no'])) {
            return [
                'type'    => TransactionVoucher::TRANSACTION_VOUCHER_TYPE_PLATFORM_ORDER_NO,
                'voucher' => $data['_platform_order_no']
            ];
        }

        return null;
    }

    /**
     * 检查交易凭证是否已存在
     */
    private function isTransactionVoucherExists(string $type, string $voucher): bool
    {
        return $this->transactionVoucherService->repository->getQuery()
            ->where([
                'transaction_voucher_type' => $type,
                'transaction_voucher'      => $voucher,
            ])->exists();
    }

    /**
     * 处理收款回调
     */
    private function handleCollectionCallback(array $result, object $modelChannel, int $channelAccountId): bool
    {
        $voucherInfo = $this->extractTransactionVoucher($result['data'] ?? []);

        $tv = $this->transactionVoucherService->repository->create([
            'channel_id'               => $modelChannel->channel_id,
            'channel_account_id'       => $channelAccountId,
            'collection_amount'        => $result['data']['_amount'] ?? 0,
            'collection_time'          => $result['data']['_pay_time'] ?? date('Y-m-d H:i:s'),
            'collection_status'        => TransactionVoucher::COLLECTION_STATUS_WAITING,
            'collection_source'        => TransactionVoucher::COLLECTION_SOURCE_INTERNAL,
            'transaction_voucher_type' => $voucherInfo['type'],
            'transaction_voucher'      => $voucherInfo['voucher'],
            'content'                  => $result['origin'] ?? '',
            'transaction_type'         => TransactionVoucher::TRANSACTION_TYPE_COLLECTION
        ]);
        if (!$tv) {
            return false;
        }

        return Redis::send(CollectionOrder::COLLECTION_ORDER_WRITE_OFF_QUEUE_NAME, [
            'transaction_voucher_id'   => $tv->id,
            'transaction_voucher_type' => $tv->transaction_voucher_type,
            'transaction_voucher'      => $tv->transaction_voucher,
            'channel_id'               => $tv->channel_id,
            'bank_account_id'          => $tv->bank_account_id,
        ]);
    }

    /**
     * 处理打款回调
     */
    private function handleDisbursementCallback(array $result): bool
    {
        return Redis::send(DisbursementOrder::DISBURSEMENT_ORDER_WRITE_OFF_QUEUE_NAME, [
            'upstream_order_no' => $result['data']['_upstream_order_no'] ?? '',
            'platform_order_no' => $result['data']['_platform_order_no'] ?? '',
            'amount'            => $result['data']['_amount'] ?? '0.00',
            'utr'               => $result['data']['_utr'] ?? '',
            'rejection_reason'  => $result['data']['_rejection_reason'] ?? '',
            'payment_status'    => $result['data']['_payment_status'],
            'order_data'        => $result['origin'] ?? '',
        ]);
    }

    /**
     * 记录回调开始
     */
    private function recordCallbackStart(Request $request, ModelChannel $modelChannel, string $callbackId, string $callbackType): object
    {
        return $this->callbackRecordRepository->create([
            'callback_id'          => $callbackId,
            'channel_id'           => $modelChannel->id,
            'original_request_id'  => '', // 这里可以根据需要关联到原始请求ID
            'callback_type'        => $callbackType,
            'callback_url'         => $request->fullUrl(),
            'callback_http_method' => $request->method(),
            'callback_params'      => json_encode($request->all(), JSON_UNESCAPED_UNICODE),
            'callback_headers'     => json_encode($request->header(), JSON_UNESCAPED_UNICODE),
            'callback_body'        => $request->rawBody(),
            'callback_time'        => Carbon::now(),
            'client_ip'            => $request->getRealIp(),
            'verification_status'  => 0, // 0-未验签
            'response_content'     => '',
            'process_result'       => '处理中...',
            'elapsed_time'         => 0,
        ]);
    }

    /**
     * 更新回调记录
     */
    private function updateCallbackRecord(int $callbackRecordId, bool $success, string $processResult, float $elapsedTime): void
    {
        try {
            $this->callbackRecordRepository->updateById($callbackRecordId, [
                'verification_status' => $success ? 1 : 2, // 1-验签成功, 2-验签失败
                'process_result'      => $processResult,
                'elapsed_time'        => (int)($elapsedTime * 1000), // 转换为毫秒
                'response_content'    => $success ? 'success' : 'failed',
            ]);
        } catch (\Throwable $e) {
            Log::error('更新回调记录失败', [
                'callback_record_id' => $callbackRecordId,
                'error'              => $e->getMessage()
            ]);
        }
    }
}