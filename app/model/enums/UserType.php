<?php

namespace app\model\enums;

use app\constants\User;
use Hyperf\Constants\Annotation\Constants;
use Hyperf\Constants\Annotation\Message;
use Hyperf\Constants\EnumConstantsTrait;

#[Constants]
enum UserType: int
{
    use EnumConstantsTrait;

    #[Message('user.enums.type.100')]
    case SYSTEM = User::TYPE_SYSTEM;

    #[Message('user.enums.type.200')]
    case Guest = User::TYPE_GUEST;
}
