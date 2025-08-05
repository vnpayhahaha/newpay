<?php

namespace app\constants;

use app\constants\lib\ConstantsOptionTrait;

class DisbursementOrder
{
    use ConstantsOptionTrait;

    // 订单状态:\r\n    0-创建 10-待支付 11-待回填 20-成功 30-挂起 \r\n    40-失败 41-已取消 43-已失效 44-已退款
    public const STATUS_CREATE = 0;
    public const STATUS_WAIT_PAY = 10;
    public const STATUS_WAIT_FILL = 11;
    public const STATUS_SUCCESS = 20;
    public const STATUS_SUSPEND = 30;
    public const STATUS_FAIL = 40;
    public const STATUS_CANCEL = 41;
    public const STATUS_INVALID = 43;
    public const STATUS_REFUND = 44;
    public static array $status_list = [
        self::STATUS_CREATE    => 'disbursement_order.enums.status.0',
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
    public static array $payment_type_list = [
        self::PAYMENT_TYPE_BANK_CARD => 'disbursement_order.enums.payment_type.bank_card',
        self::PAYMENT_TYPE_UPI       => 'disbursement_order.enums.payment_type.upi',
    ];

    // notify_status 通知状态:0-未通知 1-通知成功 2-通知失败 3-回调中
    public const NOTIFY_STATUS_NOT_NOTIFY = 0;
    public const NOTIFY_STATUS_NOTIFY_SUCCESS = 1;
    public const NOTIFY_STATUS_NOTIFY_FAIL = 2;
    public const NOTIFY_STATUS_CALLBACK_ING = 3;
    public static array $notify_status_list = [
        self::NOTIFY_STATUS_NOT_NOTIFY     => 'disbursement_order.enums.notify_status.not_notify',
        self::NOTIFY_STATUS_NOTIFY_SUCCESS => 'disbursement_order.enums.notify_status.notify_success',
        self::NOTIFY_STATUS_NOTIFY_FAIL    => 'disbursement_order.enums.notify_status.notify_fail',
        self::NOTIFY_STATUS_CALLBACK_ING   => 'disbursement_order.enums.notify_status.callback_ing',
    ];
}