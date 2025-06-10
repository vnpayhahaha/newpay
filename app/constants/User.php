<?php

namespace app\constants;

use app\constants\lib\ConstantsOptionTrait;

class User
{
    use ConstantsOptionTrait;

    // 状态 (1正常 2停用)
    public const STATUS_NORMAL  = 1;
    public const STATUS_DISABLE = 2;
    public static array $status_list = [
        self::STATUS_NORMAL  => 'user.enums.status.1',
        self::STATUS_DISABLE => 'user.enums.status.2',
    ];

    // 用户类型：(100系统用户 200测试用户)
    public const TYPE_SYSTEM = 100;
    public const TYPE_GUEST  = 200;
    public static array $type_list = [
        self::TYPE_SYSTEM => 'user.enums.type.100',
        self::TYPE_GUEST  => 'user.enums.type.200',
    ];
}
