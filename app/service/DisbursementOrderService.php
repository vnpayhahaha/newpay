<?php

namespace app\service;

use app\constants\DisbursementOrder;
use app\constants\Tenant;
use app\constants\TenantAccount;
use app\constants\TransactionVoucher;
use app\exception\BusinessException;
use app\lib\enum\ResultCode;
use app\model\ModelDisbursementOrder;
use app\model\ModelTenantApp;
use app\repository\BankAccountRepository;
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

    // 创建订单
    public function createOrder(array $data, string $source = ''): array
    {
        // 查询租户获取配置
        $findTenant = $this->tenantRepository->getQuery()->where('tenant_id', $data['tenant_id'])->first();
        $request = Context::get(Request::class);
        $app = Context::get(ModelTenantApp::class);
        // test 调试使用
        if (!$app) {
            $app = ModelTenantApp::getQuery()->where('app_key', $data['app_key'])->first();
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
        $disbursementOrder = $this->repository->create([
            'tenant_id'          => $data['tenant_id'],
            'tenant_order_no'    => $data['tenant_order_no'],
            'amount'             => $data['amount'],
            'order_source'       => $source,
            'notify_remark'      => $data['notify_remark'] ?? '',
            'notify_url'         => $data['notify_url'] ?? '',
            'fixed_fee'          => $calculate['fixed_fee'],
            'rate_fee'           => $calculate['rate_fee'],
            'rate_fee_amount'    => $calculate['rate_fee_amount'],
            'total_fee'          => $calculate['total_fee'],
            'settlement_amount'  => bcadd($data['amount'], $calculate['total_fee'], 4),
            'expire_time'        => date('Y-m-d H:i:s', strtotime('+' . $findTenant->payment_expire_minutes . ' minutes')),
            'payment_type'       => $data['payment_type'],
            'payee_bank_name'    => $data['payee_bank_name'] ?? '',
            'payee_bank_code'    => $data['payee_bank_code'] ?? '',
            'payee_account_name' => $data['payee_account_name'] ?? '',
            'payee_account_no'   => $data['payee_account_no'] ?? '',
            'payee_phone'        => $data['payee_phone'] ?? '',
            'payee_upi'          => $data['payee_upi'] ?? '',
            'app_id'             => $app->id ?? '',
            'status'             => DisbursementOrder::STATUS_WAIT_PAY,
            'request_id'         => $request->requestId,
        ]);
        if (!filled($disbursementOrder)) {
            throw new BusinessException(ResultCode::ORDER_CREATE_FAILED);
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
        if (!in_array($order->status, [DisbursementOrder::STATUS_WAIT_PAY, DisbursementOrder::STATUS_SUSPEND, DisbursementOrder::STATUS_INVALID], true)) {
            throw new BusinessException(ResultCode::ORDER_STATUS_ERROR);
        }
        $tenantAccount = $this->tenantAccountRepository->getQuery()
            ->where('tenant_id', $order->tenant_id)
            ->where('account_type', TenantAccount::ACCOUNT_TYPE_PAY)
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
            $isOk = $this->transactionRecordRepository->orderTransaction(
                $order->id,
                $order->platform_order_no,
                $tenantAccount,
                $order->amount,
                $order->total_fee
            );
            if (!$isOk) {
                throw new Exception('Failed to update the recharge record');
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
                    'utr'                    => $transactionVoucher->transaction_voucher_type === TransactionVoucher::TRANSACTION_VOUCHER_TYPE_UTR ? $transactionVoucher->transaction_voucher : '',
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
}
