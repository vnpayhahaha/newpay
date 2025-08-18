<?php

namespace app\event;

use app\model\ModelTransactionRawData;
use app\repository\TransactionParsingRulesRepository;
use support\Container;

class TransactionRawDataEvent
{
    public function Created(ModelTransactionRawData $model): void
    {
        /** @var TransactionParsingRulesRepository $transactionParsingRulesRepository */
        $transactionParsingRulesRepository = Container::make(TransactionParsingRulesRepository::class);
        $parseResult = $transactionParsingRulesRepository->regularParsing($model->id, $model->channel_id, $model->content);
        var_dump('$parseResult==', $parseResult);
    }
}