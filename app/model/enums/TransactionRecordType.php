<?php

namespace app\model\enums;

use app\constants\TransactionRecord;
use app\lib\traits\ConstantsTrait;

enum TransactionRecordType: int
{
    use ConstantsTrait;

    case BASE_RECEIVE = TransactionRecord::TYPE_BASE_RECEIVE;
    case BASE_PAY = TransactionRecord::TYPE_BASE_PAY;
    case BASE_TRANSFER = TransactionRecord::TYPE_BASE_TRANSFER;
    case REFUND_RECEIVE = TransactionRecord::TYPE_REFUND_RECEIVE;
    case REFUND_PAY = TransactionRecord::TYPE_REFUND_PAY;
    case FEE_RECEIVE = TransactionRecord::TYPE_FEE_RECEIVE;
    case FEE_PAY = TransactionRecord::TYPE_FEE_PAY;
    case FEE_TRANSFER = TransactionRecord::TYPE_FEE_TRANSFER;
    case ADJUST_INCREASE = TransactionRecord::TYPE_ADJUST_INCREASE;
    case ADJUST_DECREASE = TransactionRecord::TYPE_ADJUST_DECREASE;
    case FREEZE = TransactionRecord::TYPE_FREEZE;
    case UNFREEZE = TransactionRecord::TYPE_UNFREEZE;
    case REVERSE = TransactionRecord::TYPE_REVERSE;
    case ERROR_ADJUST = TransactionRecord::TYPE_ERROR_ADJUST;
}
