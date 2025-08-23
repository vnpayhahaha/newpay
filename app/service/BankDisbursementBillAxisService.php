<?php

namespace app\service;

use app\repository\BankDisbursementBillAxisRepository;
use DI\Attribute\Inject;

class BankDisbursementBillAxisService extends IService
{
    #[Inject]
    public BankDisbursementBillAxisRepository $repository;
}