<?php

namespace app\service;

use app\model\ModelBankDisbursementUpload;
use app\repository\BankDisbursementBillAxisNeoRepository;
use app\service\handle\BankDisbursementBillAbstract;
use DI\Attribute\Inject;

class BankDisbursementBillAxisNeoService extends BankDisbursementBillAbstract
{
    #[Inject]
    public BankDisbursementBillAxisNeoRepository $repository;

    public function importBill(ModelBankDisbursementUpload $model): bool
    {
        try {
            $this->parseData($model->id, $model->path, function ($data) use ($model) {
                if (!isset($data['particulars'], $data['dr_cr'], $data['amount_inr'], $data['tran_date']) ||
                    filled($data['particulars']) ||
                    filled($data['dr_cr']) ||
                    $data['dr_cr'] !== 'DR' ||
                    filled($data['amount_inr']) ||
                    filled($data['tran_date'])
                ) {
                    $model->increment('failure_count');
                    return false;
                }
                $data['file_hash'] = $model->hash;
                // 随机字符串
                $particulars_parse = explode('/', $data['particulars']);
                $bank_card_and_random_string = explode('-', $particulars_parse[3]);
                $bank_card_no = $bank_card_and_random_string[0];
                $random_string = $bank_card_and_random_string[1];
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = $model->created_by;
                $data['upload_id'] = $model->id;
                $bill_data = $this->repository->create($data);
                if ($bill_data) {
                    $model->increment('success_count');
                }
            });

        } catch (\Throwable $e) {
            var_dump('导入axis账单异常错误：', $e->getMessage());
            throw $e;
        }
        return false;
    }
}