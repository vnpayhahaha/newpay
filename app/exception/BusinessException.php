<?php

namespace app\exception;

use app\http\Result;
use app\http\ResultCode;
use Webman\Http\Request;
use Webman\Http\Response;

class BusinessException extends \RuntimeException
{
    private Result $response;

    public function __construct(ResultCode $code = ResultCode::FAIL, ?string $message = null, mixed $data = [])
    {
        $this->response = new Result($code, $message, $data);
    }

    public function getResponse(): Result
    {
        return $this->response;
    }

    public function render(Request $request): ?Response
    {
        // json请求返回json数据
        if ($request->expectsJson()) {
            return json(['code' => $this->getCode() ?: 500, 'message' => $this->response->message]);
        }
        // 非json请求则返回一个页面
        return new Response(200, [], $this->getMessage());
    }
}

