<?php

namespace app\repository;

use app\model\ModelTenantApp;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TenantAppRepository.
 * @extends IRepository<ModelTenantApp>
 */
class TenantAppRepository extends IRepository
{
    #[Inject]
    protected ModelTenantApp $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['tenant_id'])) {
            $query->where('tenant_id', $params['tenant_id']);
        }

        if (isset($params['app_name'])) {
            $query->where('app_name', $params['app_name']);
        }

        if (isset($params['app_key'])) {
            $query->where('app_key', $params['app_key']);
        }

        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        }

        return $query;
    }
}
