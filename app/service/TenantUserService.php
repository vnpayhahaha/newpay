<?php

namespace app\service;

use app\exception\UnprocessableEntityException;
use app\lib\enum\ResultCode;
use app\repository\TenantUserRepository;
use DI\Attribute\Inject;

/**
 * @extends IService<TenantUserRepository>
 */
final class TenantUserService extends IService
{
    #[Inject]
    protected TenantUserRepository $repository;


    public function resetPassword(?int $id): bool
    {
        if ($id === null) {
            return false;
        }
        $entity = $this->repository->findById($id);
        if ($entity === null) {
            throw new UnprocessableEntityException(ResultCode::USER_NOT_EXIST);
        }
        $entity->resetPassword();
        return $entity->save();
    }
}
