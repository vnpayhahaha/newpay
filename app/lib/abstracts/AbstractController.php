<?php

namespace app\lib\abstracts;

use app\http\Result;
use app\http\ResultCode;
use support\Response;

abstract class AbstractController
{
    protected function success(mixed $data = [], ?string $message = null): Response
    {

        return new Response(200, ['Content-Type' => 'application/json'], json_encode(new Result(ResultCode::SUCCESS, $message, $data)));
    }

    protected function error(?string $message = null, mixed $data = [], int $httpStatus = 500): Response
    {
        return new Response($httpStatus, ['Content-Type' => 'application/json'], json_encode(new Result(ResultCode::FAIL, $message, $data)));
    }

    protected function json(ResultCode $code, mixed $data = [], ?string $message = null, int $httpStatus = 200): Response
    {
        return new Response($httpStatus, ['Content-Type' => 'application/json'], json_encode(new Result($code, $message, $data)));
    }
}
