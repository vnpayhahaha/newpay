<?php

namespace app\constants;

use app\constants\lib\ConstantsOptionTrait;

class DisbursementOrder
{
    use ConstantsOptionTrait;

    // 订单状态:\r\n    1-创建 10-待支付 11-待回填 20-成功 30-挂起 \r\n    40-失败 41-已取消 43-已失效 44-已退款
    public const STATUS_CREATE = 1;
    public const STATUS_WAIT_PAY = 10;
    public const STATUS_WAIT_FILL = 11;
    public const STATUS_SUCCESS = 20;
    public const STATUS_SUSPEND = 30;
    public const STATUS_FAIL = 40;
    public const STATUS_CANCEL = 41;
    public const STATUS_INVALID = 43;
    public const STATUS_REFUND = 44;
    public static array $status_list = [
        self::STATUS_CREATE    => 'disbursement_order.enums.status.1',
        self::STATUS_WAIT_PAY  => 'disbursement_order.enums.status.10',
        self::STATUS_WAIT_FILL => 'disbursement_order.enums.status.11',
        self::STATUS_SUCCESS   => 'disbursement_order.enums.status.20',
        self::STATUS_SUSPEND   => 'disbursement_order.enums.status.30',
        self::STATUS_FAIL      => 'disbursement_order.enums.status.40',
        self::STATUS_CANCEL    => 'disbursement_order.enums.status.41',
        self::STATUS_INVALID   => 'disbursement_order.enums.status.43',
        self::STATUS_REFUND    => 'disbursement_order.enums.status.44',
    ];

    //  `payment_type` tinyint(2) NOT NULL COMMENT '付款类型:1-银行卡 2-UPI',
    public const PAYMENT_TYPE_BANK_CARD = 1;
    public const PAYMENT_TYPE_UPI = 2;
    public const PAYMENT_TYPE_ENUM = [
        self::PAYMENT_TYPE_BANK_CARD => 'disbursement_order.enums.payment_type.1',
        self::PAYMENT_TYPE_UPI       => 'disbursement_order.enums.payment_type.2',
    ];
}