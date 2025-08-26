<?php

namespace app\constants;

use app\constants\lib\ConstantsOptionTrait;

class DisbursementOrderVerificationQueue
{
    use ConstantsOptionTrait;

    // 支付状态:0未支付1支付中2支付成功3支付失败
    public const PAY_STATUS_NOT_PAY = 0;
    public const PAY_STATUS_PAYING = 1;
    public const PAY_STATUS_SUCCESS = 2;
    public const PAY_STATUS_FAIL = 3;


}