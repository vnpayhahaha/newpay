<?php

namespace app\service;

use app\repository\BankDisbursementBillYesmsmeRepository;
use DI\Attribute\Inject;

class BankDisbursementBillYesmsmeService extends IService
{
    #[Inject]
    public BankDisbursementBillYesmsmeRepository $repository;
}