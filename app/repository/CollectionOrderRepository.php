<?php

namespace app\repository;

use app\model\ModelCollectionOrder;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CollectionOrderRepository.
 * @extends IRepository<ModelCollectionOrder>
 */
final class CollectionOrderRepository extends IRepository
{
    #[Inject]
    protected ModelCollectionOrder $model;

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

        if (isset($params['settlement_type'])) {
            $query->where('settlement_type', $params['settlement_type']);
        }

        if (isset($params['collection_type'])) {
            $query->where('collection_type', $params['collection_type']);
        }

        if (isset($params['collection_channel_id'])) {
            $query->where('collection_channel_id', $params['collection_channel_id']);
        }

        if (isset($params['pay_time'])) {
            $query->where('pay_time', $params['pay_time']);
        }

        if (isset($params['expire_time'])) {
            $query->where('expire_time', $params['expire_time']);
        }

        if (isset($params['order_source'])) {
            $query->where('order_source', $params['order_source']);
        }

        if (isset($params['recon_type'])) {
            $query->where('recon_type', $params['recon_type']);
        }

        if (isset($params['notify_status'])) {
            $query->where('notify_status', $params['notify_status']);
        }

        if (isset($params['tenant_id'])) {
            $query->where('tenant_id', $params['tenant_id']);
        }

        if (isset($params['app_id'])) {
            $query->where('app_id', $params['app_id']);
        }

        if (isset($params['payer_name'])) {
            $query->where('payer_name', $params['payer_name']);
        }

        if (isset($params['payer_account'])) {
            $query->where('payer_account', $params['payer_account']);
        }

        if (isset($params['payer_bank'])) {
            $query->where('payer_bank', $params['payer_bank']);
        }

        if (isset($params['payer_ifsc'])) {
            $query->where('payer_ifsc', $params['payer_ifsc']);
        }

        if (isset($params['payer_upi'])) {
            $query->where('payer_upi', $params['payer_upi']);
        }

        if (isset($params['status']) && filled($params['status'])) {
            if ($params['status'] === 40) {
                $query->where('status', '>=', $params['status']);
            } else {
                $query->where('status', $params['status']);
            }
        }

        if (isset($params['channel_transaction_no'])) {
            $query->where('channel_transaction_no', $params['channel_transaction_no']);
        }

        if (isset($params['request_id'])) {
            $query->where('request_id', $params['request_id']);
        }

        if (isset($params['platform_transaction_no'])) {
            $query->where('platform_transaction_no', $params['platform_transaction_no']);
        }

        if (isset($params['utr'])) {
            $query->where('utr', $params['utr']);
        }

        if (isset($params['customer_submitted_utr'])) {
            $query->where('customer_submitted_utr', $params['customer_submitted_utr']);
        }

        return $query;
    }

    public function page(array $params = [], ?int $page = null, ?int $pageSize = null): array
    {
        $result = $this->perQuery($this->getQuery(), $params)
            ->with('channel:id,channel_name,channel_code,channel_icon')
            ->with('channel_account:id,merchant_id')
            ->with('bank_account:id,branch_name')
            ->with('cancel_operator:id,username,nickname')
            ->paginate(
                perPage: $pageSize,
                pageName: static::PER_PAGE_PARAM_NAME,
                page: $page,
            );
        return $this->handlePage($result);
    }
}
