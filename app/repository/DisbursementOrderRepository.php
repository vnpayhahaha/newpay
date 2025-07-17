<?php

namespace app\repository;

use app\model\ModelDisbursementOrder;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class DisbursementOrderRepository.
 * @extends IRepository<ModelDisbursementOrder>
 */
final class DisbursementOrderRepository extends IRepository
{
    #[Inject]
    protected ModelDisbursementOrder $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['platform_order_no'])) {
            $query->where('platform_order_no', $params['platform_order_no']);
        }

        if (isset($params['tenant_order_no'])) {
            $query->where('tenant_order_no', $params['tenant_order_no']);
        }

        if (isset($params['upstream_order_no'])) {
            $query->where('upstream_order_no', $params['upstream_order_no']);
        }

        if (isset($params['pay_time'])) {
            $query->where('pay_time', $params['pay_time']);
        }

        if (isset($params['order_source'])) {
            $query->where('order_source', $params['order_source']);
        }

        if (isset($params['disbursement_channel_id'])) {
            $query->where('disbursement_channel_id', $params['disbursement_channel_id']);
        }

        if (isset($params['disbursement_bank_id'])) {
            $query->where('disbursement_bank_id', $params['disbursement_bank_id']);
        }

        if (isset($params['payment_type'])) {
            $query->where('payment_type', $params['payment_type']);
        }

        if (isset($params['payee_bank_name'])) {
            $query->where('payee_bank_name', $params['payee_bank_name']);
        }

        if (isset($params['payee_bank_code'])) {
            $query->where('payee_bank_code', $params['payee_bank_code']);
        }

        if (isset($params['payee_account_name'])) {
            $query->where('payee_account_name', $params['payee_account_name']);
        }

        if (isset($params['payee_account_no'])) {
            $query->where('payee_account_no', $params['payee_account_no']);
        }

        if (isset($params['payee_upi'])) {
            $query->where('payee_upi', $params['payee_upi']);
        }

        if (isset($params['utr'])) {
            $query->where('utr', $params['utr']);
        }

        if (isset($params['tenant_id'])) {
            $query->where('tenant_id', $params['tenant_id']);
        }

        if (isset($params['app_id'])) {
            $query->where('app_id', $params['app_id']);
        }

        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (isset($params['expire_time'])) {
            $query->where('expire_time', $params['expire_time']);
        }

        if (isset($params['notify_status'])) {
            $query->where('notify_status', $params['notify_status']);
        }

        if (isset($params['channel_transaction_no'])) {
            $query->where('channel_transaction_no', $params['channel_transaction_no']);
        }

        if (isset($params['request_id'])) {
            $query->where('request_id', $params['request_id']);
        }

        return $query;
    }
}
