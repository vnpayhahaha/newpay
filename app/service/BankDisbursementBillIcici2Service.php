<?php

namespace app\service;

use app\repository\BankDisbursementBillIcici2Repository;
use DI\Attribute\Inject;

class BankDisbursementBillIcici2Service extends IService
{
    #[Inject]
    public BankDisbursementBillIcici2Repository $repository;
}