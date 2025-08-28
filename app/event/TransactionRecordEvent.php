<?php

namespace app\event;

use app\constants\DisbursementOrder;
use app\constants\TenantAccount;
use app\constants\TransactionRecord;
use app\model\ModelTransactionRecord;
use app\repository\DisbursementOrderRepository;
use app\repository\TransactionQueueStatusRepository;
use app\repository\TransactionRecordRepository;
use support\Container;
use support\Log;

class TransactionRecordEvent
{
    public function Created(ModelTransactionRecord $model): void
    {
        var_dump('ModelTransactionRecord Created event==');
        /** @var TransactionQueueStatusRepository $transactionQueueStatusRepository */
        $transactionQueueStatusRepository = Container::make(TransactionQueueStatusRepository::class);
        $isAdded = $transactionQueueStatusRepository->addQueue($model->id, $model->transaction_no, $model->transaction_type);
        if (!$isAdded) {
            Log::error("TransactionRecordEvent  => Created  filed");
        }
        $newTR = Container::make(TransactionRecordRepository::class);
        $newTR->getModel()->where('id', $model->id)->update(
            [
                'transaction_status' => TransactionRecord::STATUS_PROCESSING,
            ]
        );
    }

    public function Failed(int $transactionRecordID): void
    {
        $model = ModelTransactionRecord::find($transactionRecordID);
        var_dump('ModelTransactionRecord  Failed event==', $model->toArray());
        if ($model->account_type === TenantAccount::ACCOUNT_TYPE_PAY &&
            $model->transaction_type === TransactionRecord::TYPE_ORDER_TRANSACTION &&
            $model->transaction_status === TransactionRecord::STATUS_FAIL
        ) {
            // 订单失败
            /** @var DisbursementOrderRepository $disbursementOrderRepository */
            $disbursementOrderRepository = Container::make(DisbursementOrderRepository::class);
            $disbursementOrderRepository->getModel()->where('id', $model->order_id)->update([
                'status'        => DisbursementOrder::STATUS_FAIL,
                'error_message' => $model->failed_msg,
            ]);
        }

    }

    public function Success(int $transactionRecordID): void
    {
        $model = ModelTransactionRecord::find($transactionRecordID);
        var_dump('ModelTransactionRecord  Success event==', $model->toArray());
        if ($model->account_type === TenantAccount::ACCOUNT_TYPE_PAY &&
            $model->transaction_type === TransactionRecord::TYPE_ORDER_TRANSACTION &&
            $model->transaction_status === TransactionRecord::STATUS_SUCCESS
        ) {
            // 代付订单扣款成功，订单状态改为[已创建]
            /** @var DisbursementOrderRepository $disbursementOrderRepository */
            $disbursementOrderRepository = Container::make(DisbursementOrderRepository::class);
            $disbursementOrderRepository->getModel()->where('id', $model->order_id)->update([
                'status' => DisbursementOrder::STATUS_CREATED,
            ]);
        }
    }
}
