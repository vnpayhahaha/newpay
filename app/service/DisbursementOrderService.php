<?php

namespace app\service;

use app\repository\DisbursementOrderRepository;
use DI\Attribute\Inject;

final class DisbursementOrderService extends IService
{
    #[Inject]
    public DisbursementOrderRepository $repository;
}
