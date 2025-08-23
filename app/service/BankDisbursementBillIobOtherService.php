<?php

namespace app\service;

use app\repository\BankDisbursementBillIobOtherRepository;
use DI\Attribute\Inject;

class BankDisbursementBillIobOtherService extends IService
{
    #[Inject]
    public BankDisbursementBillIobOtherRepository $repository;
}