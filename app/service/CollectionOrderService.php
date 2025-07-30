<?php

namespace app\service;

use app\constants\CollectionOrder;
use app\constants\Tenant;
use app\exception\BusinessException;
use app\exception\OpenApiException;
use app\lib\enum\ResultCode;
use app\model\ModelCollectionOrder;
use app\model\ModelTenant;
use app\model\ModelTenantApp;
use app\repository\BankAccountRepository;
use app\repository\ChannelAccountRepository;
use app\repository\CollectionOrderRepository;
use app\repository\TenantRepository;
use app\upstream\Handle\TransactionCollectionOrderFactory;
use Carbon\Carbon;
use DI\Attribute\Inject;
use Exception;
use JetBrains\PhpStorm\ArrayShape;
use support\Context;
use support\Redis;
use Webman\Http\Request;

final class CollectionOrderService extends IService
{
    #[Inject]
    public CollectionOrderRepository $repository;
    #[Inject]
    protected TenantRepository $tenantRepository;
    #[Inject]
    protected BankAccountRepository $bankAccountRepository;
    #[Inject]
    protected ChannelAccountRepository $channelAccountRepository;

    // 创建订单
    public function createOrder(array $data, string $source = ''): mixed
    {
        // 查询租户获取配置
        $findTenant = $this->tenantRepository->getQuery()
//            ->select([
//           'id','collection_use_method','upstream_enabled','safe_level','card_acquire_type'
//])
            ->where('tenant_id', $data['tenant_id'])->first();
        // 没有可用的收款方式
        if (!$findTenant || !filled($findTenant->collection_use_method)) {
            throw new OpenApiException(ResultCode::ORDER_NO_AVAILABLE_COLLECTION_METHOD);
        }
        // 启用上游第三方收款
        $upstream_enabled = $findTenant->upstream_enabled;

        $result = [];
        foreach ($findTenant->collection_use_method as $method) {
            if ($method === Tenant::COLLECTION_USE_METHOD_UPSTREAM && $upstream_enabled && filled($findTenant->upstream_items)) {
                // 上游第三方收款
                $result = $this->upstreamCollection($data, $findTenant, $source);
                break;
            }
            if ($method === Tenant::COLLECTION_USE_METHOD_BANK_ACCOUNT) {
                // 银行收款
                $result = $this->bankCollection($data, $findTenant, $source);
                break;
            }
        }
        return $result;
    }

    // 银行收款
    public function bankCollection(array $data, ModelTenant $findTenant, string $source = ''): mixed
    {
        // 查询验证是否具有安全等级匹配的银行卡
        $checkBankCard = $this->bankAccountRepository->checkBankCardOfCollection($findTenant->safe_level, (float)$data['amount']);
        if (!$checkBankCard) {
            throw new BusinessException(ResultCode::ORDER_NO_MATCHING_BANK_CARD);
        }
        // 获取等级匹配的银行卡
        $bankCardQuery = $this->bankAccountRepository->getBankCardOfCollectionQuery($findTenant->safe_level, (float)$data['amount']);
        $card = match ($findTenant->card_acquire_type) {
            Tenant::BANK_CARD_SEQUENTIAL => $bankCardQuery->orderBy('id', 'desc')->first(),
            Tenant::BANK_CARD_POLLING => $bankCardQuery->orderBy('last_used_time', 'asc')->first(),
            default => $bankCardQuery->inRandomOrder()->first(),
        };
        if (!$card) {
            throw new BusinessException(ResultCode::ORDER_NO_MATCHING_BANK_CARD);
        }
        $card->last_used_time = date('Y-m-d H:i:s');
        $card->save();

        // 计算收款费率
        $calculate = [
            'fixed_fee' => 0.00,
            'rate_fee'  => 0.00,
        ];
        if (in_array(Tenant::RECEIPT_FEE_TYPE_FIXED, $findTenant->receipt_fee_type)) {
            $calculate['fixed_fee'] = $findTenant->receipt_fixed_fee;
        }
        if (in_array(Tenant::RECEIPT_FEE_TYPE_RATE, $findTenant->receipt_fee_type)) {
            $calculate['rate_fee'] = $findTenant->receipt_fee_rate;
            $rate_fee = bcdiv($findTenant->receipt_fee_rate, '100', 4);
        }
        $rate_fee_amount = bcmul($data['amount'], $rate_fee, 4);
        $calculate['rate_fee_amount'] = $rate_fee_amount;
        $calculate['total_fee'] = bcadd($calculate['fixed_fee'], $rate_fee_amount, 4);

        $payable_amount = $data['amount'];
        if ($findTenant->float_enabled) {
            if (count($findTenant->float_range) !== 2 || bccomp((string)$findTenant->float_range[0], (string)$findTenant->float_range[1], 2) !== -1) {
                throw new BusinessException(ResultCode::ORDER_COLLECTION_FLOAT_AMOUNT_ERROR);
            }
            [$min, $max] = $findTenant->float_range;
            if (bcadd((string)$data['amount'], (string)$min) <= 0) {
                throw new BusinessException(ResultCode::ORDER_COLLECTION_AMOUNT_LESS_THAN_MIN_FLOAT_AMOUNT);
            }
            try {
                $floatAmount = $this->getFloatAmount($card->id, $data['amount'], $findTenant);
            } catch (Exception $e) {
                $errorMsg = $e->getMessage();
                if ($errorMsg === 'There is not enough available floating amount') {
                    $errorMsg .= ": bank account " . $card->account_number;
                }
                throw new BusinessException(ResultCode::ORDER_COLLECTION_FLOAT_AMOUNT_ERROR, $errorMsg);
            }
            $payable_amount = $floatAmount;
        }
        $request = Context::get(Request::class);
        $app = Context::get(ModelTenantApp::class);
        // test 调试使用
        if (!$app) {
            $app = ModelTenantApp::getQuery()->where('app_key', $data['app_key'])->first();
        }
        // 收款订单创建
        $collectionOrder = $this->repository->create([
            'tenant_id'             => $data['tenant_id'],
            'tenant_order_no'       => $data['tenant_order_no'],
            'amount'                => $data['amount'],
            'payable_amount'        => $payable_amount,
            'fixed_fee'             => $calculate['fixed_fee'],
            'rate_fee'              => $calculate['rate_fee'],
            'rate_fee_amount'       => $calculate['rate_fee_amount'],
            'total_fee'             => $calculate['total_fee'],
            'settlement_amount'     => bcsub($data['amount'], $calculate['total_fee'], 4),
            'settlement_type'       => $findTenant->receipt_settlement_type,
            'collection_type'       => CollectionOrder::COLLECTION_TYPE_BANK_ACCOUNT,
            'collection_channel_id' => $card->channel_id,
            'bank_account_id'       => $card->id,
            'expire_time'           => date('Y-m-d H:i:s', strtotime('+' . $findTenant->receipt_expire_minutes . ' minutes')),
            'order_source'          => $source,
            'notify_remark'         => $data['notify_remark'] ?? '',
            'return_url'            => $data['return_url'] ?? '',
            'notify_url'            => $data['notify_url'] ?? '',
            'app_id'                => $app->id ?? '',
            'payer_name'            => $card->account_holder,
            'payer_account'         => $card->account_number,
            'payer_bank'            => $card->bank_code,
            'payer_upi'             => $card->upi_id,
            'status'                => CollectionOrder::STATUS_PROCESSING,
            'request_id'            => $request->requestId,
            'settlement_delay_mode' => $findTenant->settlement_delay_mode,
            'settlement_delay_days' => $findTenant->settlement_delay_days,
        ]);
        if (!filled($collectionOrder)) {
            throw new BusinessException(ResultCode::ORDER_CREATE_FAILED);
        }
        return $this->formatCreatOrderResult($collectionOrder);

    }

    /**
     * 获取充值千分位小数点浮动金额
     * @throws Exception
     */
    public function getFloatAmount(int $bank_card_id, float $amount, ModelTenant $tenant): float
    {
        [$min, $max] = $tenant->float_range;
        $min100 = floor($min * 100);
        $max100 = floor($max * 100);
        $amount100 = $amount * 100;
        $range_diff = $max100 - $min100;
        $max_attempts = max(1, (int)$range_diff);
        $cache_key = CollectionOrder::ORDER_FLOAT_AMOUNT_CACHE_KEY . 'cid_' . $bank_card_id . "_amount_{$amount100}";
        $keysRedis = Redis::keys($cache_key . '_*');
        $countKeysRedis = count($keysRedis);
        if ($range_diff <= $countKeysRedis - 2) {
            throw new Exception('There is not enough available floating amount');
        }
        try {
            $random = random_int((int)$min100 + 1, (int)$max100 - 1);
        } catch (\RangeException|\Exception $e) {
            $random = mt_rand((int)$min100 + 1, (int)$max100 - 1);
        }
        $floatAmount = $random / 100;
        if ($floatAmount === 0) {
            return $this->getFloatAmount($bank_card_id, $amount, $tenant);
        }
        $resultAmount = $amount + $floatAmount;
        // 如果结果小于0.01，则重新生成随机数  判断最终返回结果不能是负数
        if ($resultAmount < 0.01) {
            return $this->getFloatAmount($bank_card_id, $amount, $tenant);
        }
        $resultAmount100 = $resultAmount * 100;
        // 查询redis
        $redisValue = Redis::get($cache_key . '_' . $resultAmount100);
        if ($redisValue) {
            return $this->getFloatAmount($bank_card_id, $amount, $tenant);
        }
        // 查数据库 collection_order 待支付状态 的 payable_amount = $resultAmount 是否存在
        if ($this->repository->getQuery()
            ->where('bank_account_id', $bank_card_id)
            ->where('payable_amount', $resultAmount)
            ->where('status', CollectionOrder::STATUS_PROCESSING)
            ->exists()
        ) {
            return $this->getFloatAmount($bank_card_id, $amount, $tenant);
        }

        $exTime = abs(intval($tenant->receipt_expire_minutes) + intval($tenant->reconcile_retain_minutes)) * 60;
        $ok = Redis::setex($cache_key . '_' . $resultAmount100, $exTime, 1);
        if (!$ok) {
            throw new Exception('Failed to set redis');
        }
        return $resultAmount;
    }

    #[ArrayShape(['platform_order_no' => "string", 'tenant_order_no' => "string", 'pay_url' => "string", 'paytm' => "string", 'upi' => "string", 'gpay' => "string", 'phonepe' => "string"])]
    public function formatCreatOrderResult(ModelCollectionOrder $collectionOrder): array
    {
        $platform_order_no = $collectionOrder->platform_order_no;
        $tenant_order_no = $collectionOrder->tenant_order_no;
        $pay_url = $collectionOrder->pay_url ?? config('app.cash_desk_url') . '?order_no=' . $collectionOrder->platform_order_no;

        if (filled($collectionOrder->payer_upi)) {
            $upi = $collectionOrder->payer_upi;
            $upi_str = explode('@', $collectionOrder->payer_upi);
            $sign = "MEYCIQCHBg/RU0nnqGczGT+3qmufIH0d4syWKuN/93J8Of+pVwIhAJRHuz0ouV+LC1+MLU9is5mIfphzIYAnLb9yRKM7lXA+";
            $order_id_code = strtolower(dechex($collectionOrder->id));
            return [
                'platform_order_no' => $platform_order_no,
                'tenant_order_no'   => $tenant_order_no,
                'pay_url'           => $pay_url,
                'paytm'             => "paytmmp://cash_wallet?pa={$upi}&pn={$upi_str[0]}&tr={$collectionOrder->platform_order_no}&tn={$order_id_code}&am={$collectionOrder->payable_amount}&cu=INR&mc=5641&url=&mode=02&purpose=00&orgid=159002&sign={$sign}&featuretype=money_transfer",
                'upi'               => "upi://pay?pa={$upi}&pn=Payment To {$upi_str[0]}&am={$collectionOrder->payable_amount}&tn={$order_id_code}&cu=INR&tr={$collectionOrder->platform_order_no}",
                'gpay'              => "gpay://pay?pa={$upi}&pn={$upi_str[0]}&tr={$collectionOrder->platform_order_no}&am={$collectionOrder->payable_amount}&tn={$order_id_code}&cu=INR&mc=5641",
                'phonepe'           => "phonepe://pay?pa={$upi}&pn={$upi_str[0]}&tr={$collectionOrder->platform_order_no}&tn={$order_id_code}&am={$collectionOrder->payable_amount}&cu=INR&mc=5641&url=&mode=02&purpose=00&orgid=159002&sign={$sign}",
            ];
        }
        return [
            'platform_order_no' => $platform_order_no,
            'tenant_order_no'   => $tenant_order_no,
            'pay_url'           => $pay_url,
            'paytm'             => '',
            'upi'               => '',
            'gpay'              => '',
            'phonepe'           => '',
        ];
    }

    // createOrderOfUpstream
    public function upstreamCollection(array $data, ModelTenant $findTenant, string $source = ''): array
    {
        foreach ($findTenant->upstream_items as $channelAccountId) {
            // 查询 渠道状态 且 满足限额
            $channel_account = $this->channelAccountRepository
                ->getChannelAccountOfCollectionQuery($channelAccountId, $data['amount'])
                ->first();
            if ($channel_account && isset($channel_account['channel']['channel_code'])) {
                $className = Tenant::$upstream_options[$channel_account['channel']['channel_code']];
                $service = TransactionCollectionOrderFactory::getInstance($className)->init($channel_account);
                $result = $service->createOrder($data['tenant_order_no'], $data['amount']);
                if ($result['ok']) {
                    return $result;
                }
                // TODO 记录订单日志
            }
        }
        return [
            'ok'      => false,
            'message' => 'Failed to create order',
        ];
    }

    // 定时任务监听订单失效
    public function orderExpire(): void
    {
        $this->repository->getQuery()
            ->where('status', CollectionOrder::STATUS_PROCESSING)
            ->where('expire_time', '<', Carbon::now())
            ->update([
                'status' => CollectionOrder::STATUS_INVALID,
            ]);
    }

}
