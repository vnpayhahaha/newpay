<?php

namespace app\service;

use app\model\ModelBankDisbursementUpload;
use app\repository\BankDisbursementBillIciciRepository;
use app\service\handle\BankDisbursementBillAbstract;
use DI\Attribute\Inject;

class BankDisbursementBillIciciService extends BankDisbursementBillAbstract
{
    #[Inject]
    public BankDisbursementBillIciciRepository $repository;

    protected array $FieldMap = [
        'pymt_mode'            => 'pymt_mode',
        'file_sequence_num'    => 'file_sequence_num',
        'debit_acct_no'        => 'debit_acct_no',
        'beneficiaryname'      => 'beneficiary_name',
        'beneficiaryaccountno' => 'beneficiary_account_no',
        'bene_ifsc_code'       => 'bene_ifsc_code',
        'amount'               => 'amount',
        'remark'               => 'remark',
        'pymt_date'            => 'pymt_date',
        'status'               => 'status',
        'rejectionreason'      => 'rejection_reason',
        'customerrefno'        => 'customer_ref_no',
        'utrno'                => 'utr_no',
    ];

    public function importBill(ModelBankDisbursementUpload $model): bool
    {
        try {
            $this->parseData($model->id, $model->path, function ($data) use ($model) {
                if (!isset($data['remark'], $data['amount'])) {
                    $model->increment('failure_count');
                    return false;
                }
                $data['file_hash'] = $model->hash;
                // 格式化$data['pymt_date'], 由  24-09-2024 => 2024-09-24
                $data['pymt_date'] = date('Y-m-d', strtotime($data['pymt_date']));

                $data['order_no '] = $data['remark'];
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = $model->created_by;
                $data['upload_id'] = $model->id;
                $bill_data = $this->repository->create($data);
                if ($bill_data) {
                    $model->increment('success_count');
                }
                return [
                    'order_no' => $data['order_no'],
                    'amount'   => $data['amount'],
                    'utr'      => $data['utr_no'] ?? '',
                ];
            });

        } catch (\Throwable $e) {
            var_dump('导入icici账单异常错误：', $e->getMessage());
            throw $e;
        }
        return false;
    }
}