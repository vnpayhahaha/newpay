<?php

namespace app\repository;

use app\model\ModelTenantUser;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TenantUserRepository.
 * @extends IRepository<ModelTenantUser>
 */
final class TenantUserRepository extends IRepository
{
    #[Inject]
    protected ModelTenantUser $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['tenant_id'])) {
            $query->where('tenant_id', $params['tenant_id']);
        }

        if (isset($params['username'])) {
            $query->where('username', $params['username']);
        }

        if (isset($params['phone'])) {
            $query->where('phone', $params['phone']);
        }

        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (isset($params['is_enabled_google'])) {
            $query->where('is_enabled_google', $params['is_enabled_google']);
        }

        if (isset($params['remark'])) {
            $query->where('remark', $params['remark']);
        }

        return $query;
    }
}
