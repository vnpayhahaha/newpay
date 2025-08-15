<?php

namespace app\repository;

use app\model\ModelTransactionRawData;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;


class TransactionRawDataRepository extends IRepository
{
    #[Inject]
    protected ModelTransactionRawData $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['content']) && filled($params['content'])) {
            $query->where('content', $params['content']);
        }

        if (isset($params['source']) && filled($params['source'])) {
            $query->where('source', $params['source']);
        }

        if (isset($params['status']) && filled($params['status'])) {
            $query->where('status', $params['status']);
        }

        return $query;
    }
}
