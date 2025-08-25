<?php

namespace app\service;

use app\model\ModelBankDisbursementUpload;
use app\repository\BankDisbursementBillIobOtherRepository;
use app\service\handle\BankDisbursementBillAbstract;
use DI\Attribute\Inject;

class BankDisbursementBillIobOtherService extends BankDisbursementBillAbstract
{
    #[Inject]
    public BankDisbursementBillIobOtherRepository $repository;

    public function importBill(ModelBankDisbursementUpload $model): bool
    {
        // TODO: Implement importBill() method.
        return false;
    }
}