<?php

namespace app\service;

use app\exception\BusinessException;
use app\exception\UnprocessableEntityException;
use app\lib\attribute\DataScope;
use app\lib\enum\ResultCode;
use app\model\enums\ScopeType;
use app\model\ModelUser;
use app\repository\UserRepository;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Collection;
use support\Db;


/**
 * @extends IService<UserRepository>
 */
final class UserService extends IService
{
    #[Inject]
    protected UserRepository $repository;

    #[DataScope(
        scopeType: ScopeType::CREATED_BY,
        onlyTables: ['user']
    )]
    public function page(array $params, int $page = 1, int $pageSize = 10): array
    {
        return parent::page($params, $page, $pageSize);
    }

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

    public function updateById(mixed $id, array $data): mixed
    {
        return Db::transaction(function () use ($id, $data) {
            /** @var null|ModelUser $entity */
            $entity = $this->repository->findById($id);
            if (empty($entity)) {
                throw new BusinessException(ResultCode::USER_NOT_EXIST);
            }
            $entity->fill($data)->save();
            $this->handleWith($entity, $data);
        });
    }

    public function create(array $data): mixed
    {
        return Db::transaction(function () use ($data) {
            /** @var ModelUser $entity */
            $entity = parent::create($data);
            $this->handleWith($entity, $data);
        });
    }

    protected function handleWith(ModelUser $entity, array $data): void
    {
        if (isset($data['department'])) {
            $entity->department()->sync($data['department']);
        }
        if (isset($data['position'])) {
            $entity->position()->sync($data['position']);
        }
        if (!empty($data['policy'])) {
            $policy = $entity->policy()->first();
            if ($policy) {
                $policy->fill($data['policy'])->save();
            } else {
                $entity->policy()->create($data['policy']);
            }
        }
    }

    public function getUserRoles(int $id): Collection
    {
        return $this->repository->findById($id)->roles()->get();
    }
}
