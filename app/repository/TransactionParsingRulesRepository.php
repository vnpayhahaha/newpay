<?php
namespace app\repository;

use app\model\ModelTransactionParsingRules;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;


class TransactionParsingRulesRepository extends IRepository
{
    #[Inject]
    protected ModelTransactionParsingRules $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['channel_id']) && filled($params['channel_id'])) {
            $query->where('channel_id', $params['channel_id']);
        }

        if (isset($params['variable_name']) && filled($params['variable_name'])) {
            $query->where('variable_name', $params['variable_name']);
        }

        if (isset($params['status']) && filled($params['status'])) {
            $query->where('status', $params['status']);
        }

        return $query;
    }
}
