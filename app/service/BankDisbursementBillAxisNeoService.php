<?php

namespace app\service;

use app\repository\BankDisbursementBillAxisNeoRepository;
use DI\Attribute\Inject;

class BankDisbursementBillAxisNeoService extends IService
{
    #[Inject]
    public BankDisbursementBillAxisNeoRepository $repository;
}