<?php

namespace app\service;

use app\repository\BankDisbursementBillIobSameRepository;
use DI\Attribute\Inject;

class BankDisbursementBillIobSameService extends IService
{
    #[Inject]
    public BankDisbursementBillIobSameRepository $repository;
}