<?php

namespace app\constants;

use app\constants\lib\ConstantsOptionTrait;

class TransactionParsingRules
{
    use ConstantsOptionTrait;

    // 状态：1启用 0禁用
    public const STATUS_ENABLE = 1;
    public const STATUS_DISABLE = 0;
    public static array $status_list = [
        self::STATUS_ENABLE  => 'transaction_parsing_rules.enums.status.enable',
        self::STATUS_DISABLE => 'transaction_parsing_rules.enums.status.disable',
    ];

    // variable_name 金额\utr\编码\余额
    public const VARIABLE_NAME_AMOUNT = 'amount';
    public const VARIABLE_NAME_UTR = 'utr';
    public const VARIABLE_NAME_CODE = 'code';
    public const VARIABLE_NAME_BALANCE = 'balance';
    public static array $variable_name_list = [
        self::VARIABLE_NAME_AMOUNT  => 'transaction_parsing_rules.enums.variable_name.amount',
        self::VARIABLE_NAME_UTR     => 'transaction_parsing_rules.enums.variable_name.utr',
        self::VARIABLE_NAME_CODE    => 'transaction_parsing_rules.enums.variable_name.code',
        self::VARIABLE_NAME_BALANCE => 'transaction_parsing_rules.enums.variable_name.balance',
    ];
}