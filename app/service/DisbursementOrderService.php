<?php

namespace app\service;

use app\constants\CollectionOrder;
use app\constants\DisbursementOrder;
use app\constants\Tenant;
use app\constants\TenantAccount;
use app\constants\TenantNotificationQueue;
use app\constants\TransactionVoucher;
use app\exception\BusinessException;
use app\lib\annotation\Cacheable;
use app\lib\enum\ResultCode;
use app\lib\LdlExcel\PhpOffice;
use app\model\ModelBankDisbursementDownload;
use app\model\ModelDisbursementOrder;
use app\model\ModelTenantApp;
use app\repository\AttachmentRepository;
use app\repository\BankAccountRepository;
use app\repository\BankDisbursementDownloadRepository;
use app\repository\ChannelAccountRepository;
use app\repository\DisbursementOrderRepository;
use app\repository\TenantAccountRepository;
use app\repository\TenantNotificationQueueRepository;
use app\repository\TenantRepository;
use app\repository\TransactionRecordRepository;
use app\repository\TransactionVoucherRepository;
use DI\Attribute\Inject;
use Exception;
use http\Exception\RuntimeException;
use Illuminate\Database\Eloquent\Builder;
use support\Context;
use support\Db;
use support\Response;
use Webman\Event\Event;
use Webman\Http\Request;
use Webman\RedisQueue\Redis;
use Workerman\Coroutine\Parallel;

class DisbursementOrderService extends BaseService
{
    #[Inject]
    public DisbursementOrderRepository $repository;
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
    protected BankDisbursementDownloadRepository $downloadFileRepository;
    #[Inject]
    protected AttachmentRepository $attachmentRepository;
    #[Inject]
    protected TenantNotificationQueueRepository $tenantNotificationQueueRepository;

    // 创建订单
    public function createOrder(array $data, string $source = ''): array
    {
        // 查询租户获取配置
        $findTenant = $this->tenantRepository->getQuery()->where('tenant_id', $data['tenant_id'])->first();
        $request = Context::get(Request::class);
        $user = $request->user ?? null;
        $app = Context::get(ModelTenantApp::class);
        $tenantAccount = $this->tenantAccountRepository->getQuery()
            ->where('tenant_id', $data['tenant_id'])
            ->where('account_type', TenantAccount::ACCOUNT_TYPE_PAY)
            ->with('tenant')
            ->first();
        if (!$tenantAccount) {
            throw new BusinessException(ResultCode::TENANT_ACCOUNT_NOT_EXIST);
        }
        // 计算收款费率
        $calculate = [
            'fixed_fee'       => 0.00,
            'rate_fee'        => 0.00,
            'rate_fee_amount' => 0.00,
        ];
        $rate_fee = bcdiv($findTenant->payment_fee_rate, '100', 4);
        if (in_array(Tenant::PAYMENT_FEE_TYPE_FIXED, $findTenant->payment_fee_type, true)) {
            $calculate['fixed_fee'] = $findTenant->payment_fixed_fee;
        }
        if (in_array(Tenant::PAYMENT_FEE_TYPE_RATE, $findTenant->payment_fee_type, true)) {
            $calculate['rate_fee'] = $findTenant->payment_fee_rate;
            $calculate['rate_fee_amount'] = bcmul($data['amount'], $rate_fee, 4);
        }
        $calculate['total_fee'] = bcadd($calculate['fixed_fee'], $calculate['rate_fee_amount'], 4);
        Db::beginTransaction();
        try {
            $disbursementOrder = $this->repository->create([
                'tenant_id'           => $data['tenant_id'],
                'tenant_order_no'     => $data['tenant_order_no'],
                'amount'              => $data['amount'],
                'order_source'        => $source,
                'notify_remark'       => $data['notify_remark'] ?? '',
                'notify_url'          => $data['notify_url'] ?? '',
                'fixed_fee'           => $calculate['fixed_fee'],
                'rate_fee'            => $calculate['rate_fee'],
                'rate_fee_amount'     => $calculate['rate_fee_amount'],
                'total_fee'           => $calculate['total_fee'],
                'settlement_amount'   => bcadd($data['amount'], $calculate['total_fee'], 4),
                'expire_time'         => date('Y-m-d H:i:s', strtotime('+' . $findTenant->payment_expire_minutes . ' minutes')),
                'payment_type'        => $data['payment_type'],
                'payee_bank_name'     => $data['payee_bank_name'] ?? '',
                'payee_bank_code'     => $data['payee_bank_code'] ?? '',
                'payee_account_name'  => $data['payee_account_name'] ?? '',
                'payee_account_no'    => $data['payee_account_no'] ?? '',
                'payee_phone'         => $data['payee_phone'] ?? '',
                'payee_upi'           => $data['payee_upi'] ?? '',
                'app_id'              => $app->id ?? 0,
                'status'              => DisbursementOrder::STATUS_CREATING,
                'request_id'          => $request->requestId,
                'customer_created_by' => $user->id ?? 0,
            ]);
            if (!filled($disbursementOrder)) {
                throw new BusinessException(ResultCode::ORDER_CREATE_FAILED);
            }
            // 扣款
            $modelTransactionRecord = $this->transactionRecordRepository->orderTransaction(
                $disbursementOrder->id,
                $disbursementOrder->platform_order_no,
                $tenantAccount,
                -$disbursementOrder->amount,
                -$disbursementOrder->total_fee
            );
            if (!$modelTransactionRecord) {
                throw new \RuntimeException('Failed to update the recharge record');
            }
            $this->repository->getModel()->where('id', $disbursementOrder->id)->update([
                'transaction_record_id' => $modelTransactionRecord->id,
            ]);
            Db::commit();
        } catch (Exception $e) {
            Db::rollBack();
            throw $e;
        }
        // 执行成功，添加队列
        // 交易队列
        Event::dispatch('app.transaction.created', $modelTransactionRecord);
        return [
            'platform_order_no' => $disbursementOrder->platform_order_no,
            'tenant_order_no'   => $disbursementOrder->tenant_order_no,
            'amount'            => $disbursementOrder->amount,
            'status'            => $disbursementOrder->status,
        ];
    }

    // 核销订单
    public function writeOff(int $disbursementOrderId, int $transactionVoucherId): bool
    {
        /** @var ModelDisbursementOrder $order */
        $order = $this->repository->getQuery()->find($disbursementOrderId);
        if (!$order) {
            throw new BusinessException(ResultCode::ORDER_NOT_FOUND);
        }
        if (!in_array($order->status, [
            DisbursementOrder::STATUS_WAIT_PAY,
            DisbursementOrder::STATUS_SUSPEND,
            DisbursementOrder::STATUS_INVALID
        ], true)) {
            throw new BusinessException(ResultCode::ORDER_STATUS_ERROR);
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
                throw new \RuntimeException('The update of the voucher table failed');
            }
            // 更新订单表 transaction_voucher_id  status
            $isOk = $this->repository->getQuery()
                ->where('id', $disbursementOrderId)
                ->where(function (Builder $query) {
                    $query->where('status', DisbursementOrder::STATUS_WAIT_PAY)
                        ->orWhere('status', DisbursementOrder::STATUS_SUSPEND)
                        ->orWhere('status', DisbursementOrder::STATUS_INVALID);
                })
                ->update([
                    'status'                 => DisbursementOrder::STATUS_SUCCESS,
                    'transaction_voucher_id' => $transactionVoucherId,
                    'pay_time'               => date('Y-m-d H:i:s'),
                    'utr'                    => $transactionVoucher->transaction_voucher_type === TransactionVoucher::TRANSACTION_VOUCHER_TYPE_UTR ?
                        $transactionVoucher->transaction_voucher : '',
                ]);
            if (!$isOk) {
                throw new \RuntimeException('Failed to update the order');
            }

            Db::commit();
        } catch (\Throwable $exception) {
            Db::rollBack();
            throw new BusinessException(ResultCode::ORDER_VERIFY_FAILED, $exception->getMessage());
        }
        // 回调通知队列
        $disbursementOrder = $this->repository->findById($disbursementOrderId);
        $this->notify($disbursementOrder, [
            [
                'tenant_id'         => $disbursementOrder->tenant_id,
                'app_id'            => $disbursementOrder->app_id,
                'platform_order_no' => $disbursementOrder->platform_order_no,
                'tenant_order_no'   => $disbursementOrder->tenant_order_no,
                'status'            => $disbursementOrder->status,
                'pay_time'          => $disbursementOrder->pay_time,
                'refund_at'         => $disbursementOrder->refund_at,
                'refund_reason'     => $disbursementOrder->refund_reason,
                'amount'            => $disbursementOrder->amount,
                'total_fee'         => $disbursementOrder->total_fee,
                'settlement_amount' => $disbursementOrder->settlement_amount,
                'utr'               => $disbursementOrder->utr,
                'notify_remark'     => $disbursementOrder->notify_remark,
                'created_at'        => $disbursementOrder->created_at,
            ]
        ], 5);
        // 构建交易凭证图片并存储
        $disbursementOrder->payment_voucher_image = $this->repository->buildOrderPaymentImage($disbursementOrder);
        $disbursementOrder->save();
        return $isOk;
    }

    // 管理员取消订单
    public function cancelById(mixed $id, int $operatorId): int
    {
        return Db::transaction(function () use ($id, $operatorId) {
            $cancelOkNum = false;
            if (is_array($id)) {
                $cancelOkNum = $this->repository->getModel()
                    ->whereIn('id', $id)
//                    ->where('status', '<=', DisbursementOrder::STATUS_WAIT_PAY)
                    ->whereIn('status', [
                        DisbursementOrder::STATUS_CREATED,
                        DisbursementOrder::STATUS_WAIT_PAY,
                        DisbursementOrder::STATUS_SUSPEND,
                    ])
                    ->update([
                        'status'       => DisbursementOrder::STATUS_CANCEL,
                        'cancelled_by' => $operatorId,
                        'cancelled_at' => date('Y-m-d H:i:s'),
                    ]);
                Redis::send(DisbursementOrder::DISBURSEMENT_ORDER_REFUND_QUEUE_NAME, [
                    'ids'           => $id,
                    'refund_reason' => 'Order canceled by platform administrator'
                ]);
            }
            // 如果 $id 是数字或字符串，则尝试将 $id 转换为数字
            if (is_numeric($id) || is_string($id)) {
                $cancelOkNum = $this->repository->getModel()
                    ->where('id', $id)
                    ->whereIn('status', [
                        DisbursementOrder::STATUS_CREATED,
                        DisbursementOrder::STATUS_WAIT_PAY,
                        DisbursementOrder::STATUS_SUSPEND,
                    ])
                    ->update([
                        'status'       => DisbursementOrder::STATUS_CANCEL,
                        'cancelled_by' => $operatorId,
                        'cancelled_at' => date('Y-m-d H:i:s'),
                    ]);
                Redis::send(DisbursementOrder::DISBURSEMENT_ORDER_REFUND_QUEUE_NAME, [
                    'ids'           => [$id],
                    'refund_reason' => 'Order canceled by platform administrator'
                ]);
            }
            if (!$cancelOkNum) {
                return 0;
            }
            return $cancelOkNum;
        });
    }

    // 客户取消订单
    public function cancelByCustomerId(mixed $id, int $customerId): int
    {
        return Db::transaction(function () use ($id, $customerId) {
            $cancelOkNum = false;
            if (is_array($id)) {
                $cancelOkNum = $this->repository->getModel()
                    ->whereIn('id', $id)
                    ->whereIn('status', [
                        DisbursementOrder::STATUS_CREATED,
                        DisbursementOrder::STATUS_WAIT_PAY,
                        DisbursementOrder::STATUS_SUSPEND,
                    ])
                    ->update([
                        'status'                => DisbursementOrder::STATUS_CANCEL,
                        'customer_cancelled_by' => $customerId,
                        'cancelled_at'          => date('Y-m-d H:i:s'),
                    ]);
                Redis::send(DisbursementOrder::DISBURSEMENT_ORDER_REFUND_QUEUE_NAME, [
                    'ids'           => $id,
                    'refund_reason' => 'Order canceled by the customer'
                ]);
            }

            // 如果 $id 是数字或字符串，则尝试将 $id 转换为数字
            if (is_numeric($id) || is_string($id)) {
                $cancelOkNum = $this->repository->getModel()
                    ->where('id', $id)
                    ->whereIn('status', [
                        DisbursementOrder::STATUS_CREATED,
                        DisbursementOrder::STATUS_WAIT_PAY,
                        DisbursementOrder::STATUS_SUSPEND,
                    ])
                    ->update([
                        'status'                => DisbursementOrder::STATUS_CANCEL,
                        'customer_cancelled_by' => $customerId,
                        'cancelled_at'          => date('Y-m-d H:i:s'),
                    ]);
                Redis::send(DisbursementOrder::DISBURSEMENT_ORDER_REFUND_QUEUE_NAME, [
                    'ids'           => [$id],
                    'refund_reason' => 'Order canceled by the customer'
                ]);
            }

            if (!$cancelOkNum) {
                return 0;
            }
            return $cancelOkNum;
        });
    }

    // 分配
    public function distribute(array $params, int $operatorId): int
    {
        return Db::transaction(function () use ($params, $operatorId) {
            return $this->repository->getModel()
                ->whereIn('id', $params['ids'])
                ->where('status', '=', DisbursementOrder::STATUS_CREATED)
                ->update([
                    'status'                  => DisbursementOrder::STATUS_WAIT_PAY,
                    'disbursement_channel_id' => $params['disbursement_channel_id'],
                    'channel_type'            => $params['channel_type'],
                    'bank_account_id'         => $params['channel_type'] === DisbursementOrder::CHANNEL_TYPE_BANK ?
                        $params['bank_account_id'] : 0,
                    'channel_account_id'      => $params['channel_type'] === DisbursementOrder::CHANNEL_TYPE_UPSTREAM ?
                        $params['channel_account_id'] : 0,
                    'updated_at'              => date('Y-m-d H:i:s'),
                ]);
        });
    }

    public function downloadBankBill(array $params): Response
    {
        $down_bill_template_id = $params['down_bill_template_id'] ?? 'icici';
        $ids = $params['ids'] ?? [];
        $bill_config = config('bankbill.' . $down_bill_template_id);
        if (!filled($bill_config)) {
            throw new BusinessException(ResultCode::ORDER_BANK_BILL_TEMPLATE_NOT_EXIST);
        }
        if (!filled($ids)) {
            throw new BusinessException(ResultCode::ORDER_NOT_FOUND);
        }
        $disbursementOrders = $this->repository->getQuery()
            ->whereIn('id', $ids)
            ->where('status', DisbursementOrder::STATUS_WAIT_PAY)
            ->where('channel_type', DisbursementOrder::CHANNEL_TYPE_BANK)
            ->with('bank_account:id,branch_name,account_holder,account_number,bank_code')
            ->get();
        if (!$disbursementOrders) {
            throw new BusinessException(ResultCode::ORDER_NOT_FOUND);
        }
        try {
            $excelData = $bill_config['down_dto_class']::formatData($disbursementOrders);
        } catch (\Throwable $e) {
            throw new BusinessException(ResultCode::ORDER_BANK_BILL_TEMPLATE_RUNTIME_ERROR, $e->getMessage());
        }

        $down_filename = $bill_config['down_filename'] ?? 'order_' . date('YmdHis');
        // $down_filename 如果值带bank_card_no，替换bank_card_no为变量 account_number
        $down_filename = str_replace('bank_card_no', $disbursementOrders[0]['bank_account']['account_number'], $down_filename);
        $down_filepath = $bill_config['down_filepath'] ?? '/public/download/file/';
        $down_suffix = $bill_config['down_suffix'] ?? 'xlsx';
        $download_path = str_replace('/public', '', $down_filepath);
        $hash = md5(json_encode($excelData, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
        $filename = $down_filename . '.' . $down_suffix;

        /** @var ModelBankDisbursementDownload $filesInfo */
        if ($filesInfo = $this->downloadFileRepository->getModel()->where(['hash' => $hash])->first()) {
            return (new Response(200, [
                'Server'                        => env('APP_NAME', 'LangDaLang'),
                'access-control-expose-headers' => 'content-disposition',
            ]))->download(BASE_PATH . $filesInfo->path, $filename)
                ->header('Content-Disposition', "attachment; filename={$filename}; filename*=UTF-8''" . rawurlencode($filename));
        }
        $result = (new PhpOffice($bill_config['down_dto_class']))->export($down_filename, $down_suffix, $down_filepath, $excelData, null, $bill_config['down_sheetIndex'] ?? 0);
        // 将文件大小转换为MB（注意：1MB = 1048576字节）
        $address = BASE_PATH . $down_filepath . $down_filename . '.' . $down_suffix;
        $fileSizeBytes = filesize($address);
        $fileSizeMB = formatSize($fileSizeBytes);

        // 检查文件是否已存在
        $attachment = $this->downloadFileRepository->getModel()->where(['hash' => $hash])->first();
        if (!$attachment) {
            $inData = [
                'storage_mode' => 'local',
                'origin_name'  => $down_filename,
                'object_name'  => $down_filename,
                'hash'         => $hash,
                'mime_type'    => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'storage_path' => $address,
                'base_path'    => $download_path,
                'suffix'       => 'xlsx',
                'size_byte'    => $fileSizeBytes,
                'size_info'    => formatBytes($fileSizeBytes),
                'url'          => env('APP_DOMAIN', 'http://127.0.0.1:9501') . $download_path . $down_filename . '.xlsx',
            ];
            $attachment = $this->attachmentRepository->getModel()->create($inData);
        }

        $downloadData = [
            'file_name'     => $down_filename,
            'attachment_id' => $attachment->id,
            'path'          => $down_filepath . $down_filename . '.' . $down_suffix,
            'hash'          => $hash,
            'file_size'     => $fileSizeMB,
            'record_count'  => count($excelData),
            'created_by'    => 1,
            'created_at'    => date('Y-m-d H:i:s'),
            'suffix'        => $down_suffix,
        ];
        $downloadFile = $this->downloadFileRepository->create($downloadData);

        // 更新订单状态
        $this->repository->getModel()->whereIn('id', $ids)
            ->where('status', DisbursementOrder::STATUS_WAIT_PAY)
            ->update([
                'status'                        => DisbursementOrder::STATUS_WAIT_FILL,
                'down_bill_template_id'         => $down_bill_template_id,
                'bank_disbursement_download_id' => $downloadFile->id,
            ]);

        return $result;

    }

    // 退款
    public function refund(int $orderId, string $refund_reason = ''): bool
    {
        $disbursementOrder = $this->repository->findById($orderId);
        if (!$disbursementOrder) {
            return false;
        }
        $tenantAccount = $this->tenantAccountRepository->getQuery()
            ->where('tenant_id', $disbursementOrder->tenant_id)
            ->where('account_type', TenantAccount::ACCOUNT_TYPE_PAY)
            ->with('tenant')
            ->first();
        if (!$tenantAccount) {
            throw new BusinessException(ResultCode::TENANT_ACCOUNT_NOT_EXIST);
        }
        $refund_at = date('Y-m-d H:i:s');
        Db::beginTransaction();
        try {
            $updateOk = $this->repository->getModel()
                ->where('id', $orderId)
                ->whereNull('refund_at')
                ->update([
                    'refund_reason' => $refund_reason,
                    'refund_at'     => $refund_at,
                ]);
            if (!$updateOk) {
                throw new RuntimeException('The order status does not meet the refund conditions, the current status value is:' . $disbursementOrder->status);
            }

            $modelTransactionRecord = $this->transactionRecordRepository->orderTransaction(
                $orderId,
                $disbursementOrder->platform_order_no,
                $tenantAccount,
                $disbursementOrder->amount,
                $disbursementOrder->total_fee
            );

            Db::commit();
        } catch (\Throwable $e) {
            Db::rollBack();
            throw $e;
        }
        // 交易队列
        Event::dispatch('app.transaction.created', $modelTransactionRecord);
        // 回调通知队列
        $disbursementOrderNotify = $this->repository->findById($orderId);
        $this->notify($disbursementOrderNotify, [
            'tenant_id'         => $disbursementOrderNotify->tenant_id,
            'app_id'            => $disbursementOrderNotify->app_id,
            'platform_order_no' => $disbursementOrderNotify->platform_order_no,
            'tenant_order_no'   => $disbursementOrderNotify->tenant_order_no,
            'status'            => $disbursementOrderNotify->status,
            'pay_time'          => $disbursementOrder->pay_time,
            'refund_at'         => $refund_at,
            'refund_reason'     => $disbursementOrderNotify->refund_reason,
            'amount'            => $disbursementOrderNotify->amount,
            'total_fee'         => $disbursementOrderNotify->total_fee,
            'settlement_amount' => $disbursementOrderNotify->settlement_amount,
            'utr'               => $disbursementOrderNotify->utr,
            'notify_remark'     => $disbursementOrderNotify->notify_remark,
            'created_at'        => $disbursementOrderNotify->created_at,
        ], 5);
        // 构建交易凭证图片并存储
        $disbursementOrder->payment_voucher_image = $this->repository->buildOrderPaymentImage($disbursementOrder);
        $disbursementOrder->save();
        return true;
    }

    // 回调通知
    public function notify(ModelDisbursementOrder $disbursementOrder, array $data, int $max_retry_count = 1): bool
    {
        if (!$disbursementOrder || !filled($disbursementOrder->notify_url)) {
            return false;
        }
        $insertOk = $this->tenantNotificationQueueRepository->create([
            'tenant_id'             => $disbursementOrder->tenant_id,
            'app_id'                => $disbursementOrder->app_id,
            'account_type'          => TenantAccount::ACCOUNT_TYPE_PAY,
            'disbursement_order_id' => $disbursementOrder->id,
            'notification_type'     => TenantNotificationQueue::NOTIFICATION_TYPE_ORDER,
            'notification_url'      => $disbursementOrder->notify_url,
            'max_retry_count'       => $max_retry_count,
            'request_data'          => json_encode($data, JSON_THROW_ON_ERROR)
        ]);
        if (!$insertOk) {
            return false;
        }
        $tenantNotificationQueue = $this->tenantNotificationQueueRepository->findById($insertOk->id);
        if ($tenantNotificationQueue->execute_status === TenantNotificationQueue::EXECUTE_STATUS_WAITING && filled($tenantNotificationQueue->notification_url)) {
            var_dump('待执行回调通知队列 TenantNotificationQueue');
            \Webman\RedisQueue\Redis::send(TenantNotificationQueue::TENANT_NOTIFICATION_QUEUE_NAME, [
                'id'                    => $tenantNotificationQueue->id,
                'tenant_id'             => $tenantNotificationQueue->tenant_id,
                'app_id'                => $tenantNotificationQueue->app_id,
                'account_type'          => $tenantNotificationQueue->account_type,
                'disbursement_order_id' => $tenantNotificationQueue->disbursement_order_id,
                'notification_type'     => $tenantNotificationQueue->notification_type,
                'notification_url'      => $tenantNotificationQueue->notification_url,
                'request_method'        => $tenantNotificationQueue->request_method,
                'request_data'          => $tenantNotificationQueue->request_data,
                'max_retry_count'       => $tenantNotificationQueue->max_retry_count,
            ]);
        }
        return $this->repository->updateById($disbursementOrder->id, [
            'notify_status' => DisbursementOrder::NOTIFY_STATUS_CALLBACK_ING,
        ]);
    }

    // 冲正 Adjusted to payment failure
    public function adjustToFailure(int $orderId): bool
    {
        $disbursementOrder = $this->repository->findById($orderId);
        if (!$disbursementOrder) {
            return false;
        }
        if ($disbursementOrder->status !== DisbursementOrder::STATUS_SUCCESS) {
            return false;
        }
        $updateOk = $this->repository->getModel()
            ->where([
                'id'     => $orderId,
                'status' => DisbursementOrder::STATUS_SUCCESS,
            ])
            ->update([
                'status' => DisbursementOrder::AdjustToFailure,
            ]);
        if (!$updateOk) {
            return false;
        }
        return $this->refund($orderId, 'Payment failure');
    }


    // 人工回调通知
    public function manualNotify(int $disbursementOrderId): bool
    {
        $disbursementOrder = $this->repository->findById($disbursementOrderId);
        if (!$disbursementOrder) {
            return false;
        }
        return $this->notify($disbursementOrder, [
            'tenant_id'         => $disbursementOrder->tenant_id,
            'app_id'            => $disbursementOrder->app_id,
            'platform_order_no' => $disbursementOrder->platform_order_no,
            'tenant_order_no'   => $disbursementOrder->tenant_order_no,
            'status'            => $disbursementOrder->status,
            'pay_time'          => $disbursementOrder->pay_time,
            'refund_at'         => $disbursementOrder->refund_at,
            'refund_reason'     => $disbursementOrder->refund_reason,
            'amount'            => $disbursementOrder->amount,
            'total_fee'         => $disbursementOrder->total_fee,
            'settlement_amount' => $disbursementOrder->settlement_amount,
            'utr'               => $disbursementOrder->utr,
            'notify_remark'     => $disbursementOrder->notify_remark,
            'created_at'        => $disbursementOrder->created_at,
        ]);
    }

    public function statisticsSuccessfulOrderRateOfTelegramBot(string $tenant_id): array
    {
        $queryWhereSql = " and tenant_id = {$tenant_id}";
        $date = date('Y-m-d');
        // 10分钟内统计
        $order_num = $this->repository->queryCountOrderNum($queryWhereSql, $date, date('Y-m-d H:i:s'));
        $order_successful_num = $this->repository->queryOrderSuccessfulNum($queryWhereSql, $date, date('Y-m-d H:i:s'));
        // 10分钟内统计
        $order_num_10_minutes = $this->repository->queryCountOrderNum($queryWhereSql, date('Y-m-d H:i:s', strtotime('-10 minutes')), date('Y-m-d H:i:s'));
        $order_successful_num_10_minutes = $this->repository->queryOrderSuccessfulNum($queryWhereSql, date('Y-m-d H:i:s', strtotime('-10 minutes')), date('Y-m-d H:i:s'));
        // 30分钟内统计
        $order_num_30_minutes = $this->repository->queryCountOrderNum($queryWhereSql, date('Y-m-d H:i:s', strtotime('-30 minutes')), date('Y-m-d H:i:s'));
        $order_successful_num_30_minutes = $this->repository->queryOrderSuccessfulNum($queryWhereSql, date('Y-m-d H:i:s', strtotime('-30 minutes')), date('Y-m-d H:i:s'));
        // 60分钟内统计
        $order_num_60_minutes = $this->repository->queryCountOrderNum($queryWhereSql, date('Y-m-d H:i:s', strtotime('-60 minutes')), date('Y-m-d H:i:s'));
        $order_successful_num_60_minutes = $this->repository->queryOrderSuccessfulNum($queryWhereSql, date('Y-m-d H:i:s', strtotime('-60 minutes')), date('Y-m-d H:i:s'));

        return [
            'order_num'                          => $order_num,
            'order_successful_num'               => $order_successful_num,
            'payment_successful_rate'            => ($order_num > 0) ?
                (bcdiv((string)$order_successful_num, (string)$order_num, 4) * 100) : 0,
            // 10分钟内统计
            'order_num_10_minutes'               => $order_num_10_minutes,
            'order_successful_num_10_minutes'    => $order_successful_num_10_minutes,
            'payment_successful_rate_10_minutes' => $order_num_10_minutes > 0 ?
                (bcdiv((string)$order_successful_num_10_minutes, (string)$order_num_10_minutes, 4) * 100) : 0.00,
            // 30分钟内统计
            'order_num_30_minutes'               => $order_num_30_minutes,
            'order_successful_num_30_minutes'    => $order_successful_num_30_minutes,
            'payment_successful_rate_30_minutes' => $order_num_30_minutes > 0 ?
                (bcdiv((string)$order_successful_num_30_minutes, (string)$order_num_30_minutes, 4) * 100) : 0.00,
            // 60分钟内统计
            'order_num_60_minutes'               => $order_num_60_minutes,
            'order_successful_num_60_minutes'    => $order_successful_num_60_minutes,
            'payment_successful_rate_60_minutes' => $order_num_60_minutes > 0 ?
                (bcdiv((string)$order_successful_num_60_minutes, (string)$order_num_60_minutes, 4) * 100) : 0.00,
        ];
    }

    // 分析统计最近一周的订单
    #[Cacheable(
        prefix: 'disbursement:collection:order:number:userId',
        value: '_#{userId}}',
        ttl: 60,
        group: 'redis'
    )]
    protected function statisticsOrderNumberOfWeek(int $userId): array
    {
        // 计算近7天的日期范围，每天的订单数量
        $parallel = new Parallel(7);
        $user = Context::get('user');
        for ($i = 6; $i >= 0; $i--) {
            $parallel->add(function () use ($i, $user) {
                Context::set('user', $user);
                $query = $this->repository->getQuery();
                $date = date('Y-m-d', strtotime('-' . $i . ' day'));
                $date_range[$date] = $this->repository->getModel()->scopeWithTenantPermission($query)->where('created_at', '>=', $date)->where('created_at', '<', date('Y-m-d', strtotime('+1 day', strtotime($date))))->count();
                return $date_range;
            });
        }
        $results = $parallel->wait();
        // order_num_range 合并 $results 的值
        $order_num_range = array_merge(...$results);
        // $order_num_range 数组排序
        ksort($order_num_range);
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $endDate = date('Y-m-d', strtotime('+1 day'));
        $startDate = date('Y-m-d', strtotime('-6 days'));
        return [
            'count'     => $order_num_range[$today],
            'yesterday' => $order_num_range[$yesterday],
            'growth'    => (int)bcsub($order_num_range[$today], $order_num_range[$yesterday], 0),
            'chartData' => format_chart_data_x_y_date_count($order_num_range, $startDate, $endDate),
        ];
    }

    #[Cacheable(
        prefix: 'statistics:disbursement:order:successful:userId',
        value: '_#{userId}}',
        ttl: 60,
        group: 'redis'
    )]
    protected function statisticsOrderSuccessfulNumberOfWeek(int $userId): array
    {
        // 计算近7天的日期范围，每天的成功订单数量
        $parallel = new Parallel(7);
        $user = Context::get('user');
        for ($i = 6; $i >= 0; $i--) {
            $parallel->add(function () use ($i, $user) {
                Context::set('user', $user);
                $query = $this->repository->getQuery();
                $date = date('Y-m-d', strtotime('-' . $i . ' day'));
                $date_range[$date] = $this->repository->getModel()->scopeWithTenantPermission($query)
                    ->where('status', DisbursementOrder::STATUS_SUCCESS)
                    ->where('pay_time', '>=', $date)
                    ->where('pay_time', '<', date('Y-m-d', strtotime('+1 day', strtotime($date))))
                    ->count();
                return $date_range;
            });
        }
        $results = $parallel->wait();
        // order_num_range 合并 $results 的值
        $order_num_range = array_merge(...$results);
        // $order_num_range 数组排序
        ksort($order_num_range);
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $endDate = date('Y-m-d', strtotime('+1 day'));
        $startDate = date('Y-m-d', strtotime('-6 days'));
        return [
            'count'     => $order_num_range[$today],
            'yesterday' => $order_num_range[$yesterday],
            'growth'    => (int)bcsub($order_num_range[$today], $order_num_range[$yesterday], 0),
            'chartData' => format_chart_data_x_y_date_count($order_num_range, $startDate, $endDate),
        ];
    }

    #[Cacheable(
        prefix: 'statistics:disbursement:order:amount:userId',
        value: '_#{userId}}',
        ttl: 60,
        group: 'redis'
    )]
    protected function statisticsOrderSuccessfulAmountOfWeek(int $userId): array
    {
        // 计算近7天的日期范围，每天的成功订单数量
        $parallel = new Parallel(7);
        $user = Context::get('user');
        for ($i = 6; $i >= 0; $i--) {
            $parallel->add(function () use ($i, $user) {
                Context::set('user', $user);
                $query = $this->repository->getQuery();
                $date = date('Y-m-d', strtotime('-' . $i . ' day'));
                $total = $this->repository->getModel()->scopeWithTenantPermission($query)
                    ->where('status', DisbursementOrder::STATUS_SUCCESS)
                    ->where('pay_time', '>=', $date)
                    ->where('pay_time', '<', date('Y-m-d', strtotime('+1 day', strtotime($date))))
                    ->sum('amount');
                $date_range[$date] = number_format($total, 2, '.', ',');
                return $date_range;
            });
        }
        $results = $parallel->wait();
        // order_num_range 合并 $results 的值
        $order_num_range = array_merge(...$results);
        // $order_num_range 数组排序
        ksort($order_num_range);
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $endDate = date('Y-m-d', strtotime('+1 day'));
        $startDate = date('Y-m-d', strtotime('-6 days'));
        return [
            'count'     => $order_num_range[$today],
            'yesterday' => $order_num_range[$yesterday],
            'growth'    => bcsub($order_num_range[$today], $order_num_range[$yesterday], 0),
            'chartData' => format_chart_data_x_y_date_count($order_num_range, $startDate, $endDate, '₹'),
        ];
    }


    #[Cacheable(
        prefix: 'statistics:disbursement-success-order:hour-today:userId',
        value: '_#{userId}}',
        ttl: 60,
        group: 'redis'
    )]
    protected function getSuccessOrderCountByHourToday(int $userId): array
    {
        return $this->getSuccessOrderCountByHour($userId, date('Y-m-d'), date('Y-m-d'));
    }


    #[Cacheable(
        prefix: 'statistics:disbursement-success-order:hour-yesterday:userId',
        value: '_#{userId}}',
        ttl: 60,
        group: 'redis'
    )]
    protected function getSuccessOrderCountByHourYesterday(int $userId): array
    {
        return $this->getSuccessOrderCountByHour($userId, date('Y-m-d', strtotime('-1 day')), date('Y-m-d', strtotime('-1 day')));
    }

    #[Cacheable(
        prefix: 'statistics:disbursement-success-order:hour-week:userId',
        value: '_#{userId}}',
        ttl: 60,
        group: 'redis'
    )]
    protected function getSuccessOrderCountByHourWeek(int $userId): array
    {
        return $this->getSuccessOrderCountByHour($userId, date('Y-m-d', strtotime('-7 day')), date('Y-m-d'));
    }

    public function getSuccessOrderCountByHour(int $user_id, string $startDate, string $endDate): array
    {
        $query = $this->repository->getQuery();
        // 按小时分组获取今天的成功支付订单数量
        $order_num_range = $this->repository->getModel()
            ->scopeWithTenantPermission($query)
            ->select([
                'pay_time_hour',
                DB::raw('COUNT(*) as order_count')
            ])
            ->whereNotNull('pay_time')
            ->where('status', CollectionOrder::STATUS_SUCCESS)
            ->where('pay_time_hour', '>=', date('Ymd', strtotime($startDate)) . '00')  // 今日0点开始
            ->where('pay_time_hour', '<=', date('Ymd', strtotime($endDate)) . '23')  // 今日23点结束
            ->groupBy('pay_time_hour')
            ->orderBy('pay_time_hour')
            ->get();

        return $order_num_range->toArray();
    }


    public function tenantGetSuccessOrderCountByHour(string $tenantId, string $startDate, string $endDate): array
    {
        $query = $this->repository->getQuery();
        // 按小时分组获取今天的成功支付订单数量
        $order_num_range = $this->repository->getQuery()
            ->select([
                'pay_time_hour',
                DB::raw('COUNT(*) as order_count')
            ])
            ->where('tenant_id', $tenantId)
            ->whereNotNull('pay_time')
            ->where('status', CollectionOrder::STATUS_SUCCESS)
            ->where('pay_time_hour', '>=', date('Ymd', strtotime($startDate)) . '00')  // 今日0点开始
            ->where('pay_time_hour', '<=', date('Ymd', strtotime($endDate)) . '23')  // 今日23点结束
            ->groupBy('pay_time_hour')
            ->orderBy('pay_time_hour')
            ->get();

        return $order_num_range->toArray();
    }
}
