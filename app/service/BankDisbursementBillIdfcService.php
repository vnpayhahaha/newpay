<?php

namespace app\service;

use app\repository\BankDisbursementBillIdfcRepository;
use DI\Attribute\Inject;

class BankDisbursementBillIdfcService extends IService
{
    #[Inject]
    public BankDisbursementBillIdfcRepository $repository;
}