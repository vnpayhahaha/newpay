<?php

namespace app\service;

use app\repository\BankDisbursementBillIciciRepository;
use DI\Attribute\Inject;

class BankDisbursementBillIciciService extends IService
{
    #[Inject]
    public BankDisbursementBillIciciRepository $repository;
}