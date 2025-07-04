<?php

namespace app\repository;

use app\model\ModelTransactionQueueStatus;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TransactionQueueStatusRepository.
 * @extends IRepository<ModelTransactionQueueStatus>
 */
class TransactionQueueStatusRepository  extends IRepository
{
    #[Inject]
    protected ModelTransactionQueueStatus $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['transaction_no'])) {
            $query->where('transaction_no', $params['transaction_no']);
        }

        if (isset($params['transaction_type'])) {
            $query->where('transaction_type', $params['transaction_type']);
        }

        if (isset($params['queue_type'])) {
            $query->where('queue_type', $params['queue_type']);
        }

        if (isset($params['process_status'])) {
            $query->where('process_status', $params['process_status']);
        }

        return $query;
    }
}
