<?php

namespace app\service;

use app\model\ModelBankDisbursementUpload;
use app\repository\BankDisbursementBillAxisRepository;
use app\service\handle\BankDisbursementBillAbstract;
use DI\Attribute\Inject;

class BankDisbursementBillAxisService extends BankDisbursementBillAbstract
{
    #[Inject]
    public BankDisbursementBillAxisRepository $repository;

    public function importBill(ModelBankDisbursementUpload $model): bool
    {
        // TODO: Implement importBill() method.
        return false;
    }
}