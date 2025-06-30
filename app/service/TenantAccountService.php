<?php

namespace app\service;

use app\repository\TenantAccountRepository;
use DI\Attribute\Inject;

final class TenantAccountService extends IService
{
    #[Inject]
    protected TenantAccountRepository $repository;
}
