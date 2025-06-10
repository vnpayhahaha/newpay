<?php

namespace app\lib\abstracts;

use app\lib\enum\ResultCode;
use support\Response;

abstract class AbstractController
{
    protected function success(mixed $data = [], ?string $message = null): Response
    {

        return new Response(ResultCode::SUCCESS, $message, $data);
    }

    protected function error(ResultCode $code = ResultCode::FAIL, ?string $message = null, mixed $data = [], int $httpStatus = 500): Response
    {
        return new Response($code, $message, $data);
    }

}
