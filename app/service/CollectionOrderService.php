<?php

namespace app\service;

use app\repository\CollectionOrderRepository;
use DI\Attribute\Inject;

final class CollectionOrderService extends IService
{
    #[Inject]
    public CollectionOrderRepository $repository;


    // 创建订单
    public function createOrder(array $data): mixed
    {
        return $this->repository->create($data);
    }
}
