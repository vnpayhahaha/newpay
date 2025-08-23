<?php

namespace app\repository;

use app\model\ModelBankDisbursementBillIobOther;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Builder;

class BankDisbursementBillIobOtherRepository extends IRepository
{
    #[Inject]
    protected ModelBankDisbursementBillIobOther $model;

    public function handleSearch(Builder $query, array $params): Builder
    {

        if (isset($params['bill_id']) && filled($params['bill_id'])) {
            $query->where('bill_id', $params['bill_id']);
        }
        if (isset($params['created_by']) && filled($params['created_by'])) {
            $query->where('created_by', $params['created_by']);
        }
        if (isset($params['upload_id']) && filled($params['upload_id'])) {
            $query->where('upload_id', $params['upload_id']);
        }
        if (isset($params['order_no']) && filled($params['order_no'])) {
            $query->where('order_no', $params['order_no']);
        }
        if (isset($params['file_hash']) && filled($params['file_hash'])) {
            $query->where('file_hash', $params['file_hash']);
        }

        // 创建时间
        if (isset($params['created_at']) && is_array($params['created_at']) && count($params['created_at']) === 2) {
            $query->whereBetween(
                'created_at',
                [
                    $params['created_at'][0],
                    $params['created_at'][1]
                ]
            );
        }
        return $query;
    }
}