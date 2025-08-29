<?php

namespace app\repository;

use app\model\ModelTenantNotificationRecord;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

class TenantNotificationRecordRepository extends IRepository
{
    #[Inject]
    protected ModelTenantNotificationRecord $model;

    public function handleSearch(Builder $query, array $params): Builder
    {
        if (isset($params['tenant_id']) && filled($params['tenant_id'])) {
            $query->where('tenant_id', $params['tenant_id']);
        }
        if (isset($params['app_id']) && filled($params['app_id'])) {
            $query->where('app_id', $params['app_id']);
        }
        if (isset($params['account_type']) && filled($params['account_type'])) {
            $query->where('account_type', $params['account_type']);
        }
        if (isset($params['disbursement_order_id']) && filled($params['disbursement_order_id'])) {
            $query->where('disbursement_order_id', $params['disbursement_order_id']);
        }
        if (isset($params['notification_type']) && filled($params['notification_type'])) {
            $query->where('notification_type', $params['notification_type']);
        }
        if (isset($params['response_status']) && filled($params['response_status'])) {
            $query->where('response_status', $params['response_status']);
        }
        if (isset($params['execute_count']) && filled($params['execute_count'])) {
            $query->where('execute_count', $params['execute_count']);
        }
        if (isset($params['status']) && filled($params['status'])) {
            $query->where('status', $params['status']);
        }

        return $query;
    }
}