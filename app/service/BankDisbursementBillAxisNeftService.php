<?php

namespace app\service;

use app\repository\BankDisbursementBillAxisNeftRepository;
use DI\Attribute\Inject;

class BankDisbursementBillAxisNeftService extends IService
{
    #[Inject]
    public BankDisbursementBillAxisNeftRepository $repository;
}