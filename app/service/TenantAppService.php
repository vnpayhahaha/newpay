<?php

namespace app\service;

use app\repository\TenantAppRepository;
use DI\Attribute\Inject;

/**
 * @extends IService<TenantAppRepository>
 */
final class TenantAppService extends IService
{
    #[Inject]
    protected TenantAppRepository $repository;
}
