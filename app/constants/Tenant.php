<?php

namespace app\constants;

use app\constants\lib\ConstantsOptionTrait;

class Tenant
{
    use ConstantsOptionTrait;

    // 启用状态(1正常 0停用)
    public const STATUS_NORMAL  = 1;
    public const STATUS_DISABLE = 2;
    public static array $status_list = [
        self::STATUS_NORMAL  => 'tenant.enums.is_enabled.1',
        self::STATUS_DISABLE => 'tenant.enums.is_enabled.2',
    ];

    // 收款结算方式(1实际金额 2订单金额)
    public const SETTLEMENT_ACTUAL_AMOUNT = 1;
    public const SETTLEMENT_ORDER_AMOUNT  = 2;
    public static array $settlement_list = [
        self::SETTLEMENT_ACTUAL_AMOUNT => 'tenant.enums.settlement.1',
        self::SETTLEMENT_ORDER_AMOUNT  => 'tenant.enums.settlement.2',
    ];

    // 银行卡获取方式(1随机 2依次 3轮询)
    public const BANK_CARD_RANDOM     = 1;
    public const BANK_CARD_SEQUENTIAL = 2;
    public const BANK_CARD_POLLING    = 3;
    public static array $bank_card_list = [
        self::BANK_CARD_RANDOM     => 'tenant.enums.bank_card.1',
        self::BANK_CARD_SEQUENTIAL => 'tenant.enums.bank_card.2',
        self::BANK_CARD_POLLING    => 'tenant.enums.bank_card.3',
    ];

    // 上游第三方收款项 upstream_options
    public static array $upstream_options = [

    ];

    // payment_assign_options
    public static array $payment_assign_options = [

    ];
}
