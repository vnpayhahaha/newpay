<?php

namespace app\constants;

use app\constants\lib\ConstantsOptionTrait;

class TransactionRecord
{
    use ConstantsOptionTrait;

    // 业务交易类型：
    //# 基础交易类型 (1XX)
    //100: 收款
    //110: 付款
    //120: 转账
    const TYPE_BASE_RECEIVE  = 100;
    const TYPE_BASE_PAY      = 110;
    const TYPE_BASE_TRANSFER = 120;
    //# 退款相关 (2XX)
    //200: 收款退款
    //210: 付款退款
    const TYPE_REFUND_RECEIVE = 200;
    const TYPE_REFUND_PAY     = 210;
    //# 手续费类 (3XX)
    //300: 收款手续费
    //310: 付款手续费
    //320: 转账手续费
    const TYPE_FEE_RECEIVE  = 300;
    const TYPE_FEE_PAY      = 310;
    const TYPE_FEE_TRANSFER = 320;
    //# 资金调整 (4XX)
    //400: 资金调增（人工）
    //410: 资金调减（人工）
    //420: 冻结资金
    //430: 解冻资金
    const TYPE_ADJUST_INCREASE = 400;
    const TYPE_ADJUST_DECREASE = 410;
    const TYPE_FREEZE          = 420;
    const TYPE_UNFREEZE        = 430;
    //# 特殊交易 (9XX)
    //900: 冲正交易
    //910: 差错调整
    const TYPE_REVERSE      = 900;
    const TYPE_ERROR_ADJUST = 910;
    public static array $type_list = [
        self::TYPE_BASE_RECEIVE    => 'record.enums.type.1',
        self::TYPE_BASE_PAY        => 'record.enums.type.2',
        self::TYPE_BASE_TRANSFER   => 'record.enums.type.3',
        self::TYPE_REFUND_RECEIVE  => 'record.enums.type.4',
        self::TYPE_REFUND_PAY      => 'record.enums.type.5',
        self::TYPE_FEE_RECEIVE     => 'record.enums.type.6',
        self::TYPE_FEE_PAY         => 'record.enums.type.7',
        self::TYPE_FEE_TRANSFER    => 'record.enums.type.8',
        self::TYPE_ADJUST_INCREASE => 'record.enums.type.9',
        self::TYPE_ADJUST_DECREASE => 'record.enums.type.10',
        self::TYPE_FREEZE          => 'record.enums.type.11',
        self::TYPE_UNFREEZE        => 'record.enums.type.12',
        self::TYPE_REVERSE         => 'record.enums.type.13',
        self::TYPE_ERROR_ADJUST    => 'record.enums.type.14',
    ];

    // 交易状态:0-等待结算 1-处理中 2-已冲正 3-成功 4-失败
    public const STATUS_WAITING_SETTLEMENT = 0;
    public const STATUS_PROCESSING         = 1;
    public const STATUS_REVERSE            = 2;
    public const STATUS_SUCCESS            = 3;
    public const STATUS_FAIL               = 4;
    public static array $status_list = [
        self::STATUS_WAITING_SETTLEMENT => 'record.enums.status.0',
        self::STATUS_PROCESSING         => 'record.enums.status.1',
        self::STATUS_REVERSE            => 'record.enums.status.2',
        self::STATUS_SUCCESS            => 'record.enums.status.3',
        self::STATUS_FAIL               => 'record.enums.status.4',
    ];

    // 延迟模式:1-D0(立即) 2-D(自然日) 3-T(工作日)
    public const SETTLEMENT_DELAY_MODE_D0    = 1;
    public const SETTLEMENT_DELAY_MODE_DAY   = 2;
    public const SETTLEMENT_DELAY_MODE_TRADE = 3;
    public static array $settlement_delay_mode_list = [
        self::SETTLEMENT_DELAY_MODE_D0    => 'record.enums.settlement_delay_mode.1',
        self::SETTLEMENT_DELAY_MODE_DAY   => 'record.enums.settlement_delay_mode.2',
        self::SETTLEMENT_DELAY_MODE_TRADE => 'record.enums.settlement_delay_mode.3',
    ];

    // 节假日调整:0-不调整 1-顺延 2-提前
    public const HOLIDAY_ADJUSTMENT_NONE     = 0;
    public const HOLIDAY_ADJUSTMENT_POSTPONE = 1;
    public const HOLIDAY_ADJUSTMENT_ADVANCE  = 2;
    public static array $holiday_adjustment_list = [
        self::HOLIDAY_ADJUSTMENT_NONE     => 'record.enums.holiday_adjustment.1',
        self::HOLIDAY_ADJUSTMENT_POSTPONE => 'record.enums.holiday_adjustment.2',
        self::HOLIDAY_ADJUSTMENT_ADVANCE  => 'record.enums.holiday_adjustment.3',
    ];
}
