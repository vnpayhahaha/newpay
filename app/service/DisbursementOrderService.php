<?php

namespace app\service;

use app\constants\DisbursementOrder;
use app\constants\Tenant;
use app\constants\TenantAccount;
use app\constants\TransactionVoucher;
use app\exception\BusinessException;
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
use app\repository\TenantRepository;
use app\repository\TransactionRecordRepository;
use app\repository\TransactionVoucherRepository;
use DI\Attribute\Inject;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use support\Context;
use support\Db;
use support\Response;
use Webman\Event\Event;
use Webman\Http\Request;

final class DisbursementOrderService extends IService
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
            $oT = $this->transactionRecordRepository->orderTransaction(
                $disbursementOrder->id,
                $disbursementOrder->platform_order_no,
                $tenantAccount,
                -$disbursementOrder->amount,
                -$disbursementOrder->total_fee
            );
            if (!$oT) {
                throw new \RuntimeException('Failed to update the recharge record');
            }
            Event::dispatch('app.transaction.created', $oT);
            $this->repository->getModel()->where('id', $disbursementOrder->id)->update([
                'transaction_record_id' => $oT->id,
            ]);
            Db::commit();
        } catch (Exception $e) {
            Db::rollBack();
            throw $e;
        }

        return [
            'platform_order_no' => $disbursementOrder->platform_order_no,
            'tenant_order_no'   => $disbursementOrder->tenant_order_no,
            'amount'            => $disbursementOrder->amount,
            'status'            => $disbursementOrder->status,
        ];
    }

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
                throw new Exception('The update of the voucher table failed');
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
                throw new Exception('Failed to update the order');
            }
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
                    ->where('status', '<=', DisbursementOrder::STATUS_WAIT_PAY)
                    ->update([
                        'status'       => DisbursementOrder::STATUS_CANCEL,
                        'cancelled_by' => $operatorId,
                        'cancelled_at' => date('Y-m-d H:i:s'),
                    ]);
            }

            return $this->repository->getModel()
                ->where('id', $id)
                ->where('status', '<=', DisbursementOrder::STATUS_WAIT_PAY)
                ->update([
                    'status'       => DisbursementOrder::STATUS_CANCEL,
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
                    ->where('status', '<=', DisbursementOrder::STATUS_WAIT_PAY)
                    ->update([
                        'status'                => DisbursementOrder::STATUS_CANCEL,
                        'customer_cancelled_by' => $customerId,
                        'cancelled_at'          => date('Y-m-d H:i:s'),
                    ]);
            }

            return $this->repository->getModel()
                ->where('id', $id)
                ->where('status', '<=', DisbursementOrder::STATUS_WAIT_PAY)
                ->update([
                    'status'                => DisbursementOrder::STATUS_CANCEL,
                    'customer_cancelled_by' => $customerId,
                    'cancelled_at'          => date('Y-m-d H:i:s'),
                ]);
        });
    }

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
}
