<?php

namespace app\service;

use app\constants\CollectionOrder;
use app\constants\Tenant;
use app\constants\TenantAccount;
use app\constants\TenantNotificationQueue;
use app\constants\TransactionVoucher;
use app\exception\BusinessException;
use app\exception\OpenApiException;
use app\lib\enum\ResultCode;
use app\model\ModelCollectionOrder;
use app\model\ModelTenant;
use app\model\ModelTenantApp;
use app\repository\BankAccountRepository;
use app\repository\ChannelAccountRepository;
use app\repository\CollectionOrderRepository;
use app\repository\TenantAccountRepository;
use app\repository\TenantNotificationQueueRepository;
use app\repository\TenantRepository;
use app\repository\TransactionRecordRepository;
use app\repository\TransactionVoucherRepository;
use app\tools\Base62Converter;
use app\upstream\Handle\TransactionCollectionOrderFactory;
use Carbon\Carbon;
use DI\Attribute\Inject;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use JetBrains\PhpStorm\ArrayShape;
use support\Context;
use support\Db;
use support\Log;
use support\Redis;
use Webman\Http\Request;

final class CollectionOrderService extends IService
{
    #[Inject]
    public CollectionOrderRepository $repository;
    #[Inject]
    protected TenantRepository $tenantRepository;
    #[Inject]
    protected TenantAccountRepository $tenantAccountRepository;
    #[Inject]
    protected BankAccountRepository $bankAccountRepository;
    #[Inject]
    protected ChannelAccountRepository $channelAccountRepository;
    #[Inject]
    protected TransactionVoucherRepository $transactionVoucherRepository;
    #[Inject]
    protected TransactionRecordRepository $transactionRecordRepository;
    #[Inject]
    protected TenantNotificationQueueRepository $tenantNotificationQueueRepository;

    // 创建订单
    public function createOrder(array $data, string $source = ''): array
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
        $fail_result = '';
        foreach ($findTenant->collection_use_method as $method) {
            if ($method === Tenant::COLLECTION_USE_METHOD_UPSTREAM && $upstream_enabled && filled($findTenant->upstream_items)) {
                var_dump('上游第三方收款');
                // 上游第三方收款
                try {
                    $result = $this->upstreamCollection($data, $findTenant, $source);
                    var_dump('上游第三方收款结果：', $result);
                } catch (\Throwable $e) {
                    $fail_result = $e->getMessage();
                    Log::warning('upstream_collection_error: ' . $e->getMessage());
                    continue;
                }
                if (filled($result)) {
                    break;
                }

            }
            if ($method === Tenant::COLLECTION_USE_METHOD_BANK_ACCOUNT) {
                // 银行收款
                try {
                    $result = $this->bankCollection($data, $findTenant, $source);
                } catch (\Throwable $e) {
                    $fail_result = $e->getMessage();
                    Log::warning('bank_collection_error: ' . $e->getMessage());
                    continue;
                }
                if (filled($result)) {
                    break;
                }
            }
        }
        if (filled($fail_result) && filled($result) === false) {
            throw new BusinessException(ResultCode::ORDER_CREATE_FAILED, $fail_result);
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
            'fixed_fee'       => 0.00,
            'rate_fee'        => 0.00,
            'rate_fee_amount' => 0.00,
        ];
        $rate_fee = bcdiv($findTenant->receipt_fee_rate, '100', 4);
        if (in_array(Tenant::RECEIPT_FEE_TYPE_FIXED, $findTenant->receipt_fee_type, true)) {
            $calculate['fixed_fee'] = $findTenant->receipt_fixed_fee;
        }
        if (in_array(Tenant::RECEIPT_FEE_TYPE_RATE, $findTenant->receipt_fee_type, true)) {
            $calculate['rate_fee'] = $findTenant->receipt_fee_rate;
            $calculate['rate_fee_amount'] = bcmul($data['amount'], $rate_fee, 4);
        }
        $calculate['total_fee'] = bcadd($calculate['fixed_fee'], $calculate['rate_fee_amount'], 4);

        $payable_amount = $data['amount'];
        if ($findTenant->float_enabled) {
            if (count($findTenant->float_range) !== 2 || bccomp((string)$findTenant->float_range[0], (string)$findTenant->float_range[1], 2) !== -1) {
                throw new BusinessException(ResultCode::ORDER_COLLECTION_FLOAT_AMOUNT_ERROR);
            }
            [
                $min,
                $max
            ] = $findTenant->float_range;
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
        $user = $request->user ?? null;
        $app = Context::get(ModelTenantApp::class);
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
            //            'settlement_type'       => CollectionOrder::SETTLEMENT_TYPE_NOT_SETTLED,
            'collection_type'       => CollectionOrder::COLLECTION_TYPE_BANK_ACCOUNT,
            'collection_channel_id' => $card->channel_id,
            'bank_account_id'       => $card->id,
            'expire_time'           => date('Y-m-d H:i:s', strtotime('+' . $findTenant->receipt_expire_minutes . ' minutes')),
            'order_source'          => $source,
            'notify_remark'         => $data['notify_remark'] ?? '',
            'return_url'            => $data['return_url'] ?? '',
            'notify_url'            => $data['notify_url'] ?? '',
            'app_id'                => $app->id ?? 0,
            'payer_name'            => $card->account_holder,
            'payer_account'         => $card->account_number,
            'payer_bank'            => $card->branch_name,
            'payer_ifsc'            => $card->bank_code,
            'payer_upi'             => $card->upi_id,
            'status'                => CollectionOrder::STATUS_PROCESSING,
            'request_id'            => $request->requestId,
            'customer_created_by'   => $user->id ?? 0,
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
        [
            $min,
            $max
        ] = $tenant->float_range;
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

        $exTime = abs((int)$tenant->receipt_expire_minutes + (int)$tenant->reconcile_retain_minutes) * 60;
        $ok = Redis::setex($cache_key . '_' . $resultAmount100, $exTime, 1);
        if (!$ok) {
            throw new Exception('Failed to set redis');
        }
        return $resultAmount;
    }


    public function formatCreatOrderResult(ModelCollectionOrder $collectionOrder): array
    {
        $platform_order_no = $collectionOrder->platform_order_no;
        $tenant_order_no = $collectionOrder->tenant_order_no;
        $pay_url = $collectionOrder->pay_url ?? config('app.cash_desk_url') . '?order_no=' . $collectionOrder->platform_order_no;

        $order_id_code = Base62Converter::decToBase62($collectionOrder->id, 5);

        if (filled($collectionOrder->payer_upi)) {
            $upi = $collectionOrder->payer_upi;
            $upi_str = explode('@', $collectionOrder->payer_upi);
            $sign = "MEYCIQCHBg/RU0nnqGczGT+3qmufIH0d4syWKuN/93J8Of+pVwIhAJRHuz0ouV+LC1+MLU9is5mIfphzIYAnLb9yRKM7lXA+";
            return [
                'platform_order_no' => $platform_order_no,
                'tenant_order_no'   => $tenant_order_no,
                'amount'            => $collectionOrder->amount,
                'payable_amount'    => $collectionOrder->payable_amount,
                'status'            => $collectionOrder->status,
                'payer_upi'         => $collectionOrder->payer_upi,
                'pay_time'          => $collectionOrder->pay_time,
                'expire_time'       => $collectionOrder->expire_time,
                'return_url'        => $collectionOrder->return_url,
                'created_at'        => $collectionOrder->created_at,
                'pay_url'           => $pay_url,
                'meta'              => [
                    'paytm'   => "paytmmp://cash_wallet?pa={$upi}&pn={$upi_str[0]}&tr={$collectionOrder->platform_order_no}&tn={$order_id_code}&am={$collectionOrder->payable_amount}&cu=INR&mc=5641&url=&mode=02&purpose=00&orgid=159002&sign={$sign}&featuretype=money_transfer",
                    'upi'     => "upi://pay?pa={$upi}&pn=Payment To {$upi_str[0]}&am={$collectionOrder->payable_amount}&tn={$order_id_code}&cu=INR&tr={$collectionOrder->platform_order_no}",
                    'gpay'    => "gpay://pay?pa={$upi}&pn={$upi_str[0]}&tr={$collectionOrder->platform_order_no}&am={$collectionOrder->payable_amount}&tn={$order_id_code}&cu=INR&mc=5641",
                    'phonepe' => "phonepe://pay?pa={$upi}&pn={$upi_str[0]}&tr={$collectionOrder->platform_order_no}&tn={$order_id_code}&am={$collectionOrder->payable_amount}&cu=INR&mc=5641&url=&mode=02&purpose=00&orgid=159002&sign={$sign}",

                ],
            ];
        }
        return [
            'platform_order_no' => $platform_order_no,
            'tenant_order_no'   => $tenant_order_no,
            'amount'            => $collectionOrder->amount,
            'payable_amount'    => $collectionOrder->payable_amount,
            'status'            => $collectionOrder->status,
            'payer_upi'         => $collectionOrder->payer_upi,
            'pay_time'          => $collectionOrder->pay_time,
            'expire_time'       => $collectionOrder->expire_time,
            'return_url'        => $collectionOrder->return_url,
            'created_at'        => $collectionOrder->created_at,
            'pay_url'           => $pay_url,
            'meta'              => [
                'paytm'   => '',
                'upi'     => '',
                'gpay'    => '',
                'phonepe' => '',
            ],

        ];
    }

    // createOrderOfUpstream
    public function upstreamCollection(array $data, ModelTenant $findTenant, string $source = ''): array
    {
        $createOrderResult = [];
        $fail_message = '';
        foreach ($findTenant->upstream_items as $channelAccountId) {
            // 查询 渠道状态 且 满足限额
            $channel_account = $this->channelAccountRepository
                ->getChannelAccountOfCollectionQuery($channelAccountId, $data['amount'])
                ->first();

            if ($channel_account && isset($channel_account['channel']['channel_code'])) {
                $className = Tenant::$upstream_options[$channel_account['channel']['channel_code']] ?? '';
                var_dump('$className ', $className);
                if (filled($className)) {
                    try {
                        $service = TransactionCollectionOrderFactory::getInstance($className)->init($channel_account);
                        $createOrderResult = $service->createOrder($data['tenant_order_no'], $data['amount']);
                    } catch (\Throwable $e) {
                        $fail_message = $e->getMessage();
                        Log::warning($className . ' 创建订单失败' . $e->getMessage());
                        continue;
                    }
                    if (filled($createOrderResult)) {
                        // todo 创建订单 [
                        //        'ok'     => 'bool',
                        //        'origin' => 'string',
                        //        'data'   => [
                        //            '_upstream_order_no' => 'string',
                        //            '_order_amount'      => 'string',
                        //            '_pay_url'           => 'string',
                        //            '_utr'               => 'string'
                        //        ]
                    }
                }
            }
        }
        if (filled($fail_message) && filled($createOrderResult) === false) {
            throw new \RuntimeException($fail_message);
        }
        return $createOrderResult;
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

    public function writeOff(int $collectionOrderId, int $transactionVoucherId): bool
    {
        /** @var ModelCollectionOrder $order */
        $order = $this->repository->getQuery()->find($collectionOrderId, [
            'id',
            'status',
            'platform_order_no',
            'tenant_id',
            'settlement_type',
            'amount',
            'paid_amount',
            'rate_fee',
            'fixed_fee',
            'settlement_delay_mode',
            'settlement_delay_days',
        ]);
        if (!$order) {
            throw new BusinessException(ResultCode::ORDER_NOT_FOUND);
        }
        if (!in_array($order->status, [
            CollectionOrder::STATUS_PROCESSING,
            CollectionOrder::STATUS_SUSPEND,
            CollectionOrder::STATUS_INVALID
        ], true)) {
            throw new BusinessException(ResultCode::ORDER_STATUS_ERROR);
        }
        $tenantAccount = $this->tenantAccountRepository->getQuery()
            ->where('tenant_id', $order->tenant_id)
            ->where('account_type', TenantAccount::ACCOUNT_TYPE_RECEIVE)
            ->with('tenant')
            ->first();
        if (!$tenantAccount) {
            throw new BusinessException(ResultCode::TENANT_ACCOUNT_NOT_EXIST);
        }
        $transactionVoucher = $this->transactionVoucherRepository->findById($transactionVoucherId);
        if (!$transactionVoucher) {
            throw new BusinessException(ResultCode::TRANSACTION_VOUCHER_NOT_EXIST);
        }
        Db::beginTransaction();
        try {
            // 更新凭证表 collection_status order_no
            $isOk = $this->transactionVoucherRepository->writeOff($transactionVoucherId, $order->platform_order_no);
            if (!$isOk) {
                throw new Exception('The update of the voucher table failed');
            }
            // 加帐
            $settlement_type = $order->settlement_type;
            $settlement_amount = $transactionVoucher->amount;
            if ($settlement_type === CollectionOrder::SETTLEMENT_TYPE_PAID_AMOUNT) {
                $settlement_amount = $transactionVoucher->collection_amount;
            }
            $rate_fee_amount = bcdiv(bcmul((string)$settlement_amount, (string)$order->rate_fee, 4), '100', 4);
            $fee_amount = bcadd($rate_fee_amount, $order->fixed_fee);
            $isOk = $this->transactionRecordRepository->orderTransaction(
                $order->id,
                $order->platform_order_no,
                $tenantAccount,
                $settlement_amount,
                -$fee_amount,
                $order->settlement_delay_mode,
                $order->settlement_delay_days,
            );
            if (!$isOk) {
                throw new Exception('Failed to update the recharge record');
            }
            // 更新订单表 transaction_voucher_id  status
            $isOk = $this->repository->getQuery()
                ->where('id', $collectionOrderId)
                ->where(function (Builder $query) {
                    $query->where('status', CollectionOrder::STATUS_PROCESSING)
                        ->orWhere('status', CollectionOrder::STATUS_SUSPEND)
                        ->orWhere('status', CollectionOrder::STATUS_INVALID);
                })
                ->update([
                    'status'                 => CollectionOrder::STATUS_SUCCESS,
                    'transaction_voucher_id' => $transactionVoucherId,
                    'settlement_type'        => $settlement_type,
                    'rate_fee_amount'        => $rate_fee_amount,
                    'total_fee'              => $fee_amount,
                    'paid_amount'            => $transactionVoucher->collection_amount,
                    'settlement_amount'      => bcsub((string)$settlement_amount, (string)$fee_amount, 4),
                    'pay_time'               => date('Y-m-d H:i:s'),
                    'utr'                    => $transactionVoucher->transaction_voucher_type === TransactionVoucher::TRANSACTION_VOUCHER_TYPE_UTR ?
                        $transactionVoucher->transaction_voucher : '',
                ]);
            if (!$isOk) {
                throw new Exception('Failed to update the order');
            }
            // 回调通知队列
            $collectionOrder = $this->repository->findById($collectionOrderId);
            $this->notify($collectionOrder, [
                [
                    'tenant_id'         => $collectionOrder->tenant_id,
                    'app_id'            => $collectionOrder->app_id,
                    'platform_order_no' => $collectionOrder->platform_order_no,
                    'tenant_order_no'   => $collectionOrder->tenant_order_no,
                    'status'            => $collectionOrder->status,
                    'pay_time'          => $collectionOrder->pay_time,
                    'amount'            => $collectionOrder->amount,
                    'total_fee'         => $collectionOrder->total_fee,
                    'settlement_amount' => $collectionOrder->settlement_amount,
                    'utr'               => $collectionOrder->utr,
                    'notify_remark'     => $collectionOrder->notify_remark,
                    'created_at'        => $collectionOrder->created_at,
                ]
            ], 5);
            Db::commit();
        } catch (\Throwable $exception) {
            Db::rollBack();
            throw new BusinessException(ResultCode::ORDER_VERIFY_FAILED, $exception->getMessage());
        }
        return $isOk;
    }

    public function cancelById(mixed $id, int $operatorId): int
    {
        return Db::transaction(function () use ($id, $operatorId) {
            if (is_array($id)) {
                return $this->repository->getModel()
                    ->whereIn('id', $id)
                    ->where('status', '<=', CollectionOrder::STATUS_PROCESSING)
                    ->update([
                        'status'       => CollectionOrder::STATUS_CANCEL,
                        'cancelled_by' => $operatorId,
                        'cancelled_at' => date('Y-m-d H:i:s'),
                    ]);
            }

            return $this->repository->getModel()
                ->where('id', $id)
                ->where('status', '<=', CollectionOrder::STATUS_PROCESSING)
                ->update([
                    'status'       => CollectionOrder::STATUS_CANCEL,
                    'cancelled_by' => $operatorId,
                    'cancelled_at' => date('Y-m-d H:i:s'),
                ]);
        });
    }

    public function cancelByCustomerId(mixed $id, int $customerId): int
    {
        return Db::transaction(function () use ($id, $customerId) {
            if (is_array($id)) {
                return $this->repository->getModel()
                    ->whereIn('id', $id)
                    ->where('status', '<=', CollectionOrder::STATUS_PROCESSING)
                    ->update([
                        'status'                => CollectionOrder::STATUS_CANCEL,
                        'customer_cancelled_by' => $customerId,
                        'cancelled_at'          => date('Y-m-d H:i:s'),
                    ]);
            }

            return $this->repository->getModel()
                ->where('id', $id)
                ->where('status', '<=', CollectionOrder::STATUS_PROCESSING)
                ->update([
                    'status'                => CollectionOrder::STATUS_CANCEL,
                    'customer_cancelled_by' => $customerId,
                    'cancelled_at'          => date('Y-m-d H:i:s'),
                ]);
        });
    }

    // 回调通知
    public function notify(ModelCollectionOrder $collectionOrder, array $data, int $max_retry_count = 1): bool
    {
        if (!$collectionOrder || !filled($collectionOrder->notify_url)) {
            return false;
        }
        $this->tenantNotificationQueueRepository->create([
            'tenant_id'             => $collectionOrder->tenant_id,
            'app_id'                => $collectionOrder->app_id,
            'account_type'          => TenantAccount::ACCOUNT_TYPE_RECEIVE,
            'disbursement_order_id' => $collectionOrder->id,
            'notification_type'     => TenantNotificationQueue::NOTIFICATION_TYPE_ORDER,
            'notification_url'      => $collectionOrder->notify_url,
            'max_retry_count'       => $max_retry_count,
            'request_data'          => json_encode($data, JSON_THROW_ON_ERROR)
        ]);
        return $this->repository->updateById($collectionOrder->id, [
            'notify_status' => CollectionOrder::NOTIFY_STATUS_CALLBACK_ING,
        ]);
    }
}
