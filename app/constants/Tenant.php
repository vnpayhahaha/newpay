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
}
