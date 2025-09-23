<?php

namespace http\common\controller;

use app\constants\CollectionOrder;
use app\constants\DisbursementOrder;
use app\constants\Tenant;
use app\constants\TransactionVoucher;
use app\controller\BasicController;
use app\lib\enum\ResultCode;
use app\router\Annotations\GetMapping;
use app\router\Annotations\RequestMapping;
use app\router\Annotations\RestController;
use app\service\ChannelService;
use app\service\CollectionOrderService;
use app\service\DisbursementOrderService;
use app\service\TransactionVoucherService;
use app\upstream\Handle\TransactionCollectionOrderFactory;
use app\upstream\Handle\TransactionDisbursementOrderFactory;
use DI\Attribute\Inject;
use support\Log;
use support\Request;
use support\Response;
use Webman\RedisQueue\Redis;

#[RestController("/callback")]
class UpstreamCallbackController extends BasicController
{

    #[Inject]
    protected ChannelService $channelService;

    #[Inject]
    protected CollectionOrderService $collectionOrderService;

    #[Inject]
    protected DisbursementOrderService $disbursementOrderService;

    #[Inject]
    protected TransactionVoucherService $transactionVoucherService;

    #[RequestMapping(path: '/collection/{channel_code}/{channel_account_id}', methods: 'get,post')]
    public function collection_order(Request $request, string $channel_code, int $channel_account_id): Response
    {

        $className = Tenant::$upstream_options[$channel_code] ?? '';
        if (!class_exists($className)) {
            return $this->error(ResultCode::INVALID_CHANNEL);
        }
        // 获取通道
        $modelChannel = $this->channelService->repository->getQuery()
            ->where('channel_code', $channel_code)
            ->first();
        if (!$modelChannel) {
            return $this->error(ResultCode::INVALID_CHANNEL);
        }
        $service = TransactionCollectionOrderFactory::getInstance($className);
        try {
            $result = $service->notify($request->all());
        } catch (\Throwable $e) {
            Log::warning($className . ' 收款订单回调失败：' . $e->getMessage());
            return $service->notifyReturn(false);
        }
        /**
         * 回调通知
         * @return array result
         *   -- bool ok
         *   -- string origin (json原始返回数据)
         *   -- array data
         *      -- string _upstream_order_no
         *      -- string _platform_order_no
         *      -- float _amount
         *      -- string _pay_time
         *      -- string _utr
         */
        if ($result['ok']) {
            $transaction_voucher_type = '';
            $transaction_voucher = '';
            if (isset($result['data']['_utr']) && filled($result['data']['_utr'])) {
                $transaction_voucher_type = TransactionVoucher::TRANSACTION_VOUCHER_TYPE_UTR;
                $transaction_voucher = $result['data']['_utr'];
            } elseif (isset($result['data']['_upstream_order_no']) && filled($result['data']['_upstream_order_no'])) {
                $transaction_voucher_type = TransactionVoucher::TRANSACTION_VOUCHER_TYPE_UPSTREAM_ORDER_NO;
                $transaction_voucher = $result['data']['_upstream_order_no'];
            } elseif (isset($result['data']['_platform_order_no']) && filled($result['data']['_platform_order_no'])) {
                $transaction_voucher_type = TransactionVoucher::TRANSACTION_VOUCHER_TYPE_PLATFORM_ORDER_NO;
                $transaction_voucher = $result['data']['_platform_order_no'];
            }
            if (!filled($transaction_voucher) || !filled($transaction_voucher_type)) {
                return $service->notifyReturn(false);
            }
            // 先查询是否存在  transaction_voucher_type  transaction_voucher
            $transactionVoucher = $this->transactionVoucherService->repository->getQuery()
                ->where([
                    'transaction_voucher_type' => $transaction_voucher_type,
                    'transaction_voucher'      => $transaction_voucher,
                ])->first();
            if ($transactionVoucher) {
                return $service->notifyReturn(true);
            }

            $tv = $this->transactionVoucherService->repository->create([
                'channel_id'               => $modelChannel->channel_id,
                'channel_account_id'       => $channel_account_id,
                'collection_amount'        => $result['data']['_amount'] ?? 0,
                'collection_time'          => $result['data']['_pay_time'] ?? date('Y-m-d H:i:s'),
                'collection_status'        => TransactionVoucher::COLLECTION_STATUS_WAITING,
                'collection_source'        => TransactionVoucher::COLLECTION_SOURCE_INTERNAL,
                'transaction_voucher_type' => $transaction_voucher_type,
                'transaction_voucher'      => $transaction_voucher,
                'content'                  => $result['origin'] ?? '',
                'transaction_type'         => TransactionVoucher::TRANSACTION_TYPE_COLLECTION
            ]);

            $isPushOk = Redis::send(CollectionOrder::COLLECTION_ORDER_WRITE_OFF_QUEUE_NAME, [
                'transaction_voucher_id'   => $tv->id,
                'transaction_voucher_type' => $tv->transaction_voucher_type,
                'transaction_voucher'      => $tv->transaction_voucher,
                'channel_id'               => $tv->channel_id,
                'bank_account_id'          => $tv->bank_account_id,
            ]);
            if (!$isPushOk) {
                return $service->notifyReturn(false);
            }
        }
        return $service->notifyReturn(true);
    }

    // 打款订单回调通知
    #[RequestMapping(path: '/disbursement/{channel_code}/{channel_account_id}', methods: 'get,post')]
    public function disbursement_order(Request $request, string $channel_code, int $channel_account_id): Response
    {
        $className = Tenant::$upstream_options[$channel_code] ?? '';
        if (!class_exists($className)) {
            return $this->error(ResultCode::INVALID_CHANNEL);
        }
        // 获取通道
        $modelChannel = $this->channelService->repository->getQuery()
            ->where('channel_code', $channel_code)
            ->first();
        if (!$modelChannel) {
            return $this->error(ResultCode::INVALID_CHANNEL);
        }
        $service = TransactionDisbursementOrderFactory::getInstance($className);
        try {
            $result = $service->notify($request->all());
        } catch (\Throwable $e) {
            Log::warning($className . ' 打款订单回调失败：' . $e->getMessage());
            return $service->notifyReturn(false);
        }
        /**
         * 回调通知
         * @return array result
         *   -- bool ok
         *   -- string origin (json原始返回数据)
         *   -- array data
         *      -- string _upstream_order_no
         *      -- string _platform_order_no
         *      -- float _amount
         *      -- string _pay_time
         *      -- string _utr
         *      -- DisbursementOrderVerificationQueuePayStatus _payment_status
         *      -- string _rejection_reason
         */
        if ($result['ok']) {
            $transaction_voucher_type = '';
            $transaction_voucher = '';
            if (isset($result['data']['_utr']) && filled($result['data']['_utr'])) {
                $transaction_voucher_type = TransactionVoucher::TRANSACTION_VOUCHER_TYPE_UTR;
                $transaction_voucher = $result['data']['_utr'];
            } elseif (isset($result['data']['_upstream_order_no']) && filled($result['data']['_upstream_order_no'])) {
                $transaction_voucher_type = TransactionVoucher::TRANSACTION_VOUCHER_TYPE_UPSTREAM_ORDER_NO;
                $transaction_voucher = $result['data']['_upstream_order_no'];
            } elseif (isset($result['data']['_platform_order_no']) && filled($result['data']['_platform_order_no'])) {
                $transaction_voucher_type = TransactionVoucher::TRANSACTION_VOUCHER_TYPE_PLATFORM_ORDER_NO;
                $transaction_voucher = $result['data']['_platform_order_no'];
            }

            if (!filled($transaction_voucher) || !filled($transaction_voucher_type)) {
                return $service->notifyReturn(false);
            }
            // 先查询是否存在  transaction_voucher_type  transaction_voucher
            $transactionVoucher = $this->transactionVoucherService->repository->getQuery()
                ->where([
                    'transaction_voucher_type' => $transaction_voucher_type,
                    'transaction_voucher'      => $transaction_voucher,
                ])->first();
            if ($transactionVoucher) {
                return $service->notifyReturn(true);
            }

            $isPushOk = Redis::send(DisbursementOrder::DISBURSEMENT_ORDER_WRITE_OFF_QUEUE_NAME, [
                'upstream_order_no' => $result['data']['_upstream_order_no'] ?? '',
                'platform_order_no' => $result['data']['_platform_order_no'] ?? '',
                'amount'            => $result['data']['_amount'] ?? '0.00',
                'utr'               => $result['data']['_utr'] ?? '',
                'rejection_reason'  => $result['data']['_rejection_reason'] ?? '',
                'payment_status'    => $result['data']['_payment_status'],
                'order_data'        => $result['origin'] ?? '',
            ]);
            if (!$isPushOk) {
                return $service->notifyReturn(false);
            }
        }
        return $service->notifyReturn(true);
    }
}