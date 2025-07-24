<?php

namespace app\repository;

use app\model\ModelTransactionVoucher;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TransactionVoucherRepository.
 * @extends IRepository<ModelTransactionVoucher>
 */
class TransactionVoucherRepository extends IRepository
{
    #[Inject]
    protected ModelTransactionVoucher $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['channel_id'])) {
            $query->where('channel_id', $params['channel_id']);
        }

        if (isset($params['channel_account_id'])) {
            $query->where('channel_account_id', $params['channel_account_id']);
        }

        if (isset($params['bank_account_id'])) {
            $query->where('bank_account_id', $params['bank_account_id']);
        }

        if (isset($params['collection_card_no'])) {
            $query->where('collection_card_no', $params['collection_card_no']);
        }

        if (isset($params['collection_time'])) {
            $query->where('collection_time', $params['collection_time']);
        }

        if (isset($params['collection_status'])) {
            $query->where('collection_status', $params['collection_status']);
        }

        if (isset($params['collection_source'])) {
            $query->where('collection_source', $params['collection_source']);
        }

        if (isset($params['transaction_voucher_type'])) {
            $query->where('transaction_voucher_type', $params['transaction_voucher_type']);
        }

        if (isset($params['order_no'])) {
            $query->where('order_no', $params['order_no']);
        }

        if (isset($params['transaction_type'])) {
            $query->where('transaction_type', $params['transaction_type']);
        }

        return $query;
    }
}
