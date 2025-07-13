<?php

namespace app\service;

use app\repository\CollectionOrderRepository;
use DI\Attribute\Inject;

final class CollectionOrderService extends IService
{
    #[Inject]
    public CollectionOrderRepository $repository;
}
