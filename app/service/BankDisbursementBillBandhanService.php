<?php

namespace app\service;

use app\repository\BankDisbursementBillBandhanRepository;
use DI\Attribute\Inject;

class BankDisbursementBillBandhanService extends IService
{
    #[Inject]
    public BankDisbursementBillBandhanRepository $repository;
}