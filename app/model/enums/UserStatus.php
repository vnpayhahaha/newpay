<?php

namespace app\model\enums;

use app\constants\User;
use Hyperf\Constants\Annotation\Constants;
use Hyperf\Constants\Annotation\Message;
use Hyperf\Constants\EnumConstantsTrait;

#[Constants]
enum UserStatus: int
{
    use EnumConstantsTrait;

    #[Message('user.enums.status.1')]
    case Normal = User::STATUS_NORMAL;

    #[Message('user.enums.status.2')]
    case DISABLE = User::STATUS_DISABLE;

    public function isNormal(): bool
    {
        return $this === self::Normal;
    }

    public function isDisable(): bool
    {
        return $this === self::DISABLE;
    }
}
