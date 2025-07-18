<?php

namespace app\lib\enum;

use app\lib\annotation\Message;
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

    #[Message('result.token_refresh_expired')]
    case TOKEN_REFRESH_EXPIRED = 100402;

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

    // 字段枚举获取失败
    #[Message('result.enum_not_found')]
    case ENUM_NOT_FOUND = 102001;

    // backend 错误码 2xxxxx  系统标识【1】-业务模块标识【2】-错误码【3】

    // 用户模块 201xxx
    #[Message('result.user_login_failed')]
    case USER_LOGIN_FAILED = 201001;
    // USER_NOT_FOUND
    #[Message('result.user_not_exist')]
    case USER_NOT_EXIST = 201002;
    // role_not_exist
    #[Message('result.role_not_exist')]
    case ROLE_NOT_EXIST = 201003;
    // USER_NUM_LIMIT_EXCEEDED
    #[Message('result.user_num_limit_exceeded')]
    case USER_NUM_LIMIT_EXCEEDED = 201004;

    // openApi
    // sign is required
    #[Message('result.openapi.system_error')]
    case OPENAPI_SYSTEM_ERROR = 202000;
    #[Message('result.openapi.sign_is_required')]
    case OPENAPI_SIGN_IS_REQUIRED = 202001;
    // app_key is required
    #[Message('result.openapi.app_key_is_required')]
    case OPENAPI_APP_KEY_IS_REQUIRED = 202002;
    // app_key is invalid
    #[Message('result.openapi.app_key_is_invalid')]
    case OPENAPI_APP_KEY_IS_INVALID = 202003;
    // sign is invalid
    #[Message('result.openapi.sign_is_invalid')]
    case OPENAPI_SIGN_IS_INVALID = 202004;
    // timestamp is required
    #[Message('result.openapi.timestamp_is_required')]
    case OPENAPI_TIMESTAMP_IS_REQUIRED = 202005;
    // timestamp is expired
    #[Message('result.openapi.timestamp_is_expired')]
    case OPENAPI_TIMESTAMP_IS_EXPIRED = 202006;
    // app is disabled
    #[Message('result.openapi.app_is_disabled')]
    case OPENAPI_APP_IS_DISABLED = 202007;
}
