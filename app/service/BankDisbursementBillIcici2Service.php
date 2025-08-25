<?php

namespace app\service;

use app\model\ModelBankDisbursementUpload;
use app\repository\BankDisbursementBillIcici2Repository;
use app\service\handle\BankDisbursementBillAbstract;
use DI\Attribute\Inject;

class BankDisbursementBillIcici2Service extends BankDisbursementBillAbstract
{
    #[Inject]
    public BankDisbursementBillIcici2Repository $repository;

    public function importBill(ModelBankDisbursementUpload $model): bool
    {
        // TODO: Implement importBill() method.
        return false;
    }
}