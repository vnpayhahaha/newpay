<?php

namespace app\service;

use app\model\ModelBankDisbursementUpload;
use app\repository\BankDisbursementBillIobSameRepository;
use app\service\handle\BankDisbursementBillAbstract;
use DI\Attribute\Inject;

class BankDisbursementBillIobSameService extends BankDisbursementBillAbstract
{
    #[Inject]
    public BankDisbursementBillIobSameRepository $repository;

    protected array $FieldMap = [
        'sno'       => 's_no',
        'name'      => 'name',
        'ifsccode'  => 'ifsc_code',
        'a/ctype'   => 'type',
        'a/cnumber' => 'number',
        'amount'    => 'amount',
        'charges'   => 'charges',
        'status'    => 'status',
        'remarks'   => 'remarks',
        'narration' => 'narration',
        'utrno'     => 'utr_no',
        'reason'    => 'reason',
    ];
    public function importBill(ModelBankDisbursementUpload $model): bool
    {
        try {
            $this->parseData($model->id, $model->path, function ($data) use ($model) {
                if (!isset($data['number'], $data['amount'], $data['status'], $data['remarks'])) {
                    $model->increment('failure_count');
                    return false;
                }
                $data['file_hash'] = $model->hash;
                $data['amount'] = str_replace(',', '', $data['amount']);

                $data['order_no '] = $data['remarks'];
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
                    // todo pay status && err_msg
                ];
            });

        } catch (\Throwable $e) {
            var_dump('导入iob same账单异常错误：', $e->getMessage());
            throw $e;
        }
        return false;
    }
}