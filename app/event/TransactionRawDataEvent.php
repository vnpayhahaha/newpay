<?php

namespace app\event;

use app\constants\TransactionRawData;
use app\constants\TransactionVoucher;
use app\model\ModelTransactionRawData;
use app\repository\BankAccountRepository;
use app\repository\TransactionParsingRulesRepository;
use app\repository\TransactionVoucherRepository;
use support\Container;

class TransactionRawDataEvent
{
    public function Created(ModelTransactionRawData $model): void
    {
        /** @var TransactionParsingRulesRepository $transactionParsingRulesRepository */
        $transactionParsingRulesRepository = Container::make(TransactionParsingRulesRepository::class);
        var_dump('$model--==', $model->toArray());
        $parseResult = $transactionParsingRulesRepository->regularParsing($model->id, $model->channel_id, $model->content);
        if (!filled($parseResult)) {
            $model->status = TransactionRawData::STATUS_PARSED_FAIL;
            $model->save();
            return;
        }
        $model->status = TransactionRawData::STATUS_PARSED_SUCCESS;
        $model->save();

        /** @var BankAccountRepository $bankAccountRepository */
        $bankAccountRepository = Container::make(BankAccountRepository::class);
        $bank_account = $bankAccountRepository->findById($model->bank_account_id);

        $parseResultKey = array_keys($parseResult);
        $transaction_voucher_type = 0;
        $transaction_voucher = '';
        if (in_array('utr', $parseResultKey)) {
            $transaction_voucher_type = TransactionVoucher::TRANSACTION_VOUCHER_TYPE_UTR;
            $transaction_voucher = $parseResult['utr'];
        } elseif (in_array('code', $parseResultKey)) {
            $transaction_voucher_type = TransactionVoucher::TRANSACTION_VOUCHER_TYPE_ORDER_NO;
            $transaction_voucher = $parseResult['code'];
        } elseif (in_array('amount', $parseResultKey)) {
            $transaction_voucher_type = TransactionVoucher::TRANSACTION_VOUCHER_TYPE_AMOUNT;
            $transaction_voucher = $parseResult['amount'];
        }

        // 创建交易凭证 TransactionVoucherRepository
        /** @var TransactionVoucherRepository $transactionVoucherRepository */
        $transactionVoucherRepository = Container::make(TransactionVoucherRepository::class);
        $transactionVoucherRepository->create([
            'channel_id'               => $model->channel_id,
            'bank_account_id'          => $model->bank_account_id,
            'collection_card_no'       => $bank_account->account_number,
            'collection_amount'        => $parseResult['amount'] ?? 0,
            'collection_time'          => date('Y-m-d H:i:s'),
            'collection_status'        => TransactionVoucher::COLLECTION_STATUS_WAITING,
            'collection_source'        => TransactionVoucher::COLLECTION_SOURCE_INTERNAL,
            'transaction_voucher_type' => $transaction_voucher_type,
            'transaction_voucher'      => $transaction_voucher,
            'content'                  => $model->content,
            'transaction_type'         => TransactionVoucher::TRANSACTION_TYPE_COLLECTION
        ]);

        // todo 核销队列
    }
}