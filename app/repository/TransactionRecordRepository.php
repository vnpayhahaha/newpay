<?php

namespace app\repository;

use app\constants\TransactionRecord;
use app\model\ModelTenantAccount;
use app\model\ModelTransactionRecord;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TransactionRecordRepository.
 * @extends IRepository<ModelTransactionRecord>
 */
class TransactionRecordRepository extends IRepository
{
    #[Inject]
    protected ModelTransactionRecord $model;

    // 业务交易类型：
    //# 基础交易类型 (1XX)
    //100: 收款
    //110: 付款
    //120: 转账
    //
    //# 退款相关 (2XX)
    //200: 收款退款
    //210: 付款退款
    //
    //# 手续费类 (3XX)
    //300: 收款手续费
    //310: 付款手续费
    //320: 转账手续费
    //
    //# 资金调整 (4XX)
    //400: 资金调增（人工）
    //410: 资金调减（人工）
    //420: 冻结资金
    //430: 解冻资金
    //
    //# 特殊交易 (9XX)
    //900: 冲正交易
    //910: 差错调整

    // 资金调整
    public function adjustFunds(int $admin_id, string $admin_username, ModelTenantAccount $account, float $amount, float $fee_amount = 0, string $remark = ''): bool
    {

        return !!$this->model::query()->create([
            'tenant_account_id'        => $account->id,
            'account_id'               => $account->account_id,
            'tenant_id'                => $account->tenant_id,
            'amount'                   => $amount,
            'fee_amount'               => $fee_amount,
            'net_amount'               => bcsub((string)$amount, (string)$fee_amount, 4),
            'account_type'             => $account->account_type,
            'transaction_type'         => $amount >= 0 ? TransactionRecord::TYPE_ADJUST_INCREASE : TransactionRecord::TYPE_ADJUST_DECREASE,
            'settlement_delay_mode'    => TransactionRecord::SETTLEMENT_DELAY_MODE_D0,
            'expected_settlement_time' => date('Y-m-d H:i:s'),
            'counterparty'             => $admin_username,
            'order_no'                 => $admin_id,
            'remark'                   => $remark,
        ]);
    }

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['transaction_no'])) {
            $query->where('transaction_no', $params['transaction_no']);
        }

        if (isset($params['account_type'])) {
            $query->where('account_type', $params['account_type']);
        }

        if (isset($params['transaction_type'])) {
            $query->where('transaction_type', $params['transaction_type']);
        }

        if (isset($params['settlement_delay_mode'])) {
            $query->where('settlement_delay_mode', $params['settlement_delay_mode']);
        }

        if (isset($params['holiday_adjustment'])) {
            $query->where('holiday_adjustment', $params['holiday_adjustment']);
        }

        if (isset($params['transaction_status'])) {
            $query->where('transaction_status', $params['transaction_status']);
        }

        return $query;
    }
}
