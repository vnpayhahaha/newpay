<?php

namespace app\constants;

use app\constants\lib\ConstantsOptionTrait;

class TenantAccountRecord
{
    use ConstantsOptionTrait;

    // 变更类型：1-订单交易 2-订单退款 3-人工加帐 4-人工减帐 5-冻结 6-解冻 7-转入 8-转出 9-冲正 10-调整差错
    public const CHANGE_TYPE_TRANSACTION  = 1;
    public const CHANGE_TYPE_REFUND       = 2;
    public const CHANGE_TYPE_MANUAL_ADD   = 3;
    public const CHANGE_TYPE_MANUAL_SUB   = 4;
    public const CHANGE_TYPE_FREEZE       = 5;
    public const CHANGE_TYPE_UNFREEZE     = 6;
    public const CHANGE_TYPE_TRANSFER_IN  = 7;
    public const CHANGE_TYPE_TRANSFER_OUT = 8;
    public const CHANGE_TYPE_REVERSE      = 9;
    public const CHANGE_TYPE_ERROR_ADJUST = 10;

}
