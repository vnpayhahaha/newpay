<?php

namespace app\service;

use app\repository\TenantApiInterfaceRepository;
use DI\Attribute\Inject;

final class TenantApiInterfaceService extends IService
{
    #[Inject]
    public TenantApiInterfaceRepository $repository;
}
