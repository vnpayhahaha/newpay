<?php

namespace app\service;

use app\model\ModelBankDisbursementUpload;
use app\repository\BankDisbursementBillBandhanRepository;
use app\service\handle\BankDisbursementBillAbstract;
use DI\Attribute\Inject;

class BankDisbursementBillBandhanService extends BankDisbursementBillAbstract
{
    #[Inject]
    public BankDisbursementBillBandhanRepository $repository;

    public function importBill(ModelBankDisbursementUpload $model): bool
    {
        // TODO: Implement importBill() method.
        return false;
    }
}