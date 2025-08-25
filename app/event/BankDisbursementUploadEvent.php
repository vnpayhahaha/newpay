<?php

namespace app\event;

use app\model\ModelBankDisbursementUpload;

class BankDisbursementUploadEvent
{
    public function Created(ModelBankDisbursementUpload $model): void
    {
        var_dump('ModelBankDisbursementUpload sleep 10s start');
        sleep(10);
        var_dump('ModelBankDisbursementUpload sleep 10s end');
    }
}