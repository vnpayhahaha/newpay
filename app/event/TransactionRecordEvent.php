<?php

namespace app\event;

use app\constants\TransactionRecord;
use app\model\ModelTransactionRecord;
use app\repository\TransactionQueueStatusRepository;
use support\Container;
use support\Log;

class TransactionRecordEvent
{
    public function Created(ModelTransactionRecord $model): void
    {
        var_dump('ModelTransactionRecord  event==');
        $transactionQueueStatusRepository = Container::make(TransactionQueueStatusRepository::class);
        $isAdded = $transactionQueueStatusRepository->addQueue($model->transaction_no, $model->transaction_type);
        if (!$isAdded) {
            Log::error("TransactionRecordEvent  => Created  filed");
        }
        $model->transaction_status = TransactionRecord::STATUS_PROCESSING;
        $model->save();
    }
}
