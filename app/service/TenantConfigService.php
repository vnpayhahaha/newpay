<?php

namespace app\service;

use app\repository\TenantConfigRepository;
use DI\Attribute\Inject;

/**
 * @extends IService<TenantConfigRepository>
 */
final class TenantConfigService extends IService
{
    #[Inject]
    public TenantConfigRepository $repository;
}
