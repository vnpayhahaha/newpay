<?php

namespace app\service;

use app\lib\attribute\DataScope;
use app\model\enums\ScopeType;
use app\repository\UserRepository;
use DI\Attribute\Inject;


/**
 * @extends IService<UserRepository>
 */
final class UserService extends IService
{
    #[Inject]
    protected  UserRepository $repository;

    #[DataScope(
        scopeType: ScopeType::CREATED_BY,
        onlyTables: ['user']
    )]
    public function page(array $params, int $page = 1, int $pageSize = 10): array
    {
        return parent::page($params, $page, $pageSize);
    }

}
