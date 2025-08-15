<?php

namespace app\repository;

use app\model\ModelTenant;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TenantRepository.
 * @extends IRepository<ModelTenant>
 */
class TenantRepository extends IRepository
{
    #[Inject]
    protected  ModelTenant $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['tenant_id']) && filled($params['tenant_id'])) {
            $query->where('tenant_id', $params['tenant_id']);
        }

        if (isset($params['contact_user_name']) && filled($params['contact_user_name'])) {
            $query->where('contact_user_name', $params['contact_user_name']);
        }

        if (isset($params['contact_phone']) && filled($params['contact_phone'])) {
            $query->where('contact_phone', $params['contact_phone']);
        }

        if (isset($params['company_name']) && filled($params['company_name'])) {
            $query->where('company_name', $params['company_name']);
        }

        if (isset($params['user_num_limit']) && filled($params['user_num_limit'])) {
            $query->where('user_num_limit', $params['user_num_limit']);
        }

        if (isset($params['is_enabled']) && filled($params['is_enabled'])) {
            $query->where('is_enabled', $params['is_enabled']);
        }

        if (isset($params['created_by']) && filled($params['created_by'])) {
            $query->where('created_by', $params['created_by']);
        }

        if (isset($params['safe_level']) && filled($params['safe_level'])) {
            $query->where('safe_level', $params['safe_level']);
        }

        return $query;
    }
}
