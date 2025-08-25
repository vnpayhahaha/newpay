<?php

namespace app\service;

use app\model\ModelBankDisbursementUpload;
use app\repository\BankDisbursementBillIobSameRepository;
use app\service\handle\BankDisbursementBillAbstract;
use DI\Attribute\Inject;

class BankDisbursementBillIobSameService extends BankDisbursementBillAbstract
{
    #[Inject]
    public BankDisbursementBillIobSameRepository $repository;

    public function importBill(ModelBankDisbursementUpload $model): bool
    {
        // TODO: Implement importBill() method.
        return false;
    }
}