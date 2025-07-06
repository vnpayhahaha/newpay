<?php

namespace app\repository;

use app\constants\TenantAccount;
use app\constants\TransactionQueueStatus;
use app\model\ModelTransactionQueueStatus;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;
use support\Log;
use Webman\RedisQueue\Redis;

/**
 * Class TransactionQueueStatusRepository.
 * @extends IRepository<ModelTransactionQueueStatus>
 */
class TransactionQueueStatusRepository extends IRepository
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

    // 加入队列
    public function addQueue(string $transaction_no, int $transaction_type): bool
    {
        // 查询是否存在
        $find = $this->model::where('transaction_no', $transaction_no)->exists();
        if ($find) {
            Log::error("TransactionQueueStatusRepository  => addQueue  transaction_no:{$transaction_no} already exists");
            return true;
        }
        $isPush = Redis::send(TenantAccount::TRANSACTION_CONSUMER_QUEUE_NAME, [
            'transaction_no'   => $transaction_no,
            'transaction_type' => $transaction_type,
        ]);
        if (!$isPush) {
            Log::error("Transaction Queue Status Repository => addQueue  filed");
        }
        var_dump("Transaction Queue Status Repository => addQueue  success");
        return !!$this->model::create([
            'transaction_no'   => $transaction_no,
            'transaction_type' => $transaction_type,
            'process_status'   => TransactionQueueStatus::STATUS_PROCESSING,
        ]);
    }
}
