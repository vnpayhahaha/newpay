<?php

namespace app\service;

use app\repository\CollectionOrderRepository;
use app\repository\TenantRepository;
use DI\Attribute\Inject;

final class CollectionOrderService extends IService
{
    #[Inject]
    public CollectionOrderRepository $repository;

    #[Inject]
    protected TenantRepository $tenantRepository;

    // 创建订单
    public function createOrder(array $data): mixed
    {

    }
}
