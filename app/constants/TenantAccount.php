<?php

namespace app\constants;

use app\constants\lib\ConstantsOptionTrait;

class TenantAccount
{
    use ConstantsOptionTrait;

    // 账户类型:1-收款账户 2-付款账户
    public const ACCOUNT_TYPE_RECEIVE = 1;
    public const ACCOUNT_TYPE_PAY     = 2;
    public static array $account_type_list = [
        self::ACCOUNT_TYPE_RECEIVE => 'tenant_account.enums.account_type.1',
        self::ACCOUNT_TYPE_PAY     => 'tenant_account.enums.account_type.2',
    ];
}
