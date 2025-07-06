<?php

namespace app\constants;

use app\constants\lib\ConstantsOptionTrait;

class TransactionRecord
{
    use ConstantsOptionTrait;

    // 业务交易类型：10-订单交易 11-订单退款 20-人工加帐 21-人工减帐 23-冻结 24-解冻 30-收转付 31-付转收 40-冲正 41-调整差错
    public const TYPE_ORDER_TRANSACTION       = 10;
    public const TYPE_ORDER_REFUND            = 11;
    public const TYPE_MANUAL_ADD              = 20;
    public const TYPE_MANUAL_SUB              = 21;
    public const TYPE_FREEZE                  = 23;
    public const TYPE_UNFREEZE                = 24;
    public const TYPE_TRANSFER_RECEIVE_TO_PAY = 30;
    public const TYPE_TRANSFER_PAY_TO_RECEIVE = 31;
    public const TYPE_REVERSE                 = 40;
    public const TYPE_ERROR_ADJUST            = 50;


    // 交易状态:0-等待结算 1-处理中 2-撤销 3-成功 4-失败
    public const STATUS_WAITING_SETTLEMENT = 0;
    public const STATUS_PROCESSING         = 1;
    public const STATUS_CANCEL             = 2;
    public const STATUS_SUCCESS            = 3;
    public const STATUS_FAIL               = 4;
    public static array $status_list = [
        self::STATUS_WAITING_SETTLEMENT => 'record.enums.status.0',
        self::STATUS_PROCESSING         => 'record.enums.status.1',
        self::STATUS_CANCEL             => 'record.enums.status.2',
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
