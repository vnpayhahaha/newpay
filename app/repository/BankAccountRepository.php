<?php

namespace app\repository;

use app\model\ModelBankAccount;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BankAccountRepository.
 * @extends IRepository<ModelBankAccount>
 */
final class BankAccountRepository extends IRepository
{
    #[Inject]
    protected ModelBankAccount $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['channel_id'])) {
            $query->where('channel_id', $params['channel_id']);
        }

        if (isset($params['branch_name'])) {
            $query->where('branch_name', $params['branch_name']);
        }

        if (isset($params['account_holder'])) {
            $query->where('account_holder', $params['account_holder']);
        }

        if (isset($params['account_number'])) {
            $query->where('account_number', $params['account_number']);
        }

        if (isset($params['bank_code'])) {
            $query->where('bank_code', $params['bank_code']);
        }

        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (isset($params['support_collection'])) {
            $query->where('support_collection', $params['support_collection']);
        }

        if (isset($params['support_disbursement'])) {
            $query->where('support_disbursement', $params['support_disbursement']);
        }

        return $query;
    }
}
