<?php

namespace app\service;

use app\model\ModelBankDisbursementUpload;
use app\repository\BankDisbursementBillAxisNeftRepository;
use app\service\handle\BankDisbursementBillAbstract;
use DI\Attribute\Inject;

class BankDisbursementBillAxisNeftService extends BankDisbursementBillAbstract
{
    #[Inject]
    public BankDisbursementBillAxisNeftRepository $repository;

    protected array $FieldMap = [
        'receipientname' => 'receipient_name',
        'accountnumber'  => 'account_number',
        'ifsccode'       => 'ifsc_code',
        'amount'         => 'amount',
        'description'    => 'description',
        'status'         => 'status',
        'failurereason'  => 'failure_reason',
    ];

    public function importBill(ModelBankDisbursementUpload $model): bool
    {
        try {
            $this->parseData($model->id, $model->path, function ($data) use ($model) {
                if (!isset($data['description'], $data['status'], $data['amount'])) {
                    $model->increment('failure_count');
                    return false;
                }
                $data['file_hash'] = $model->hash;
                $data['amount'] = str_replace(',', '', $data['amount']);
                // transaction_voucher 取$data['description']最后6位字符串
                $transaction_voucher = substr($data['description'], -6);
                // bank_card_no 截取掉$data['description']最后6位字符串
                $bank_card_no = substr($data['description'], 0, -6);

                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = $model->created_by;
                $data['upload_id'] = $model->id;
                $bill_data = $this->repository->create($data);
                if ($bill_data) {
                    $model->increment('success_count');
                }
            });

        } catch (\Throwable $e) {
            var_dump('导入axis neft账单异常错误：', $e->getMessage());
            throw $e;
        }
        return false;
    }


}