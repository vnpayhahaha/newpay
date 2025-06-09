<?php

namespace app\http;

use app\lib\attribute\Message;
use app\lib\traits\ConstantsTrait;

enum ResultCode: int
{
    use ConstantsTrait;

    // System Level Errors
    #[Message('result.success')]
    case SUCCESS = 200;

    #[Message('result.unknown')]
    case UNKNOWN = 100500;

    #[Message('result.fail')] // 503
    case FAIL = 100503;

    #[Message('result.bad_request')] // 400
    case BAD_REQUEST = 100400;

    #[Message('result.unauthorized')]
    case UNAUTHORIZED = 100401;

    #[Message('result.forbidden')]
    case FORBIDDEN = 100403;

    #[Message('result.not_found')]
    case NOT_FOUND = 100404;

    #[Message('result.method_not_allowed')]
    case METHOD_NOT_ALLOWED = 100405;

    #[Message('result.not_acceptable')]
    case NOT_ACCEPTABLE = 100406;

    #[Message('result.request_timeout')]
    case REQUEST_TIMEOUT = 100408;

    #[Message('result.conflict')]
    case CONFLICT = 100409;

    #[Message('result.payload_too_large')]
    case PAYLOAD_TOO_LARGE = 100413;

    #[Message('result.unprocessable_entity')]
    case UNPROCESSABLE_ENTITY = 100422;

    // Business Logic Validation Errors
    #[Message('result.disabled')]
    case DISABLED = 101001;


    // backend 错误码 2xxxxx  系统标识【1】-业务模块标识【2】-错误码【3】

    // 用户模块 201xxx
    #[Message('result.user_login_failed')]
    case USER_LOGIN_FAILED = 201001;
}
