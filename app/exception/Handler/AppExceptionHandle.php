<?php

namespace app\exception\Handler;

use app\http\ResultCode;
use support\exception\Handler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Webman\Http\Request;
use Webman\Http\Response;

class AppExceptionHandle extends Handler
{
    public function render(Request $request, Throwable $e): Response
    {
        // 判断异常类型，进行不同的处理
        if ($e instanceof HttpException) {
            return $this->renderHttpException($request, $e);
        } else {
            return $this->renderOtherException($request, $e);
        }
    }

    protected function renderHttpException(Request $request, HttpException $e): Response
    {
        $statusCode = $e->getStatusCode();
        $data = config('app.debug') ? [
            'file'  => $e->getFile(),
            'line'  => $e->getLine(),
            'trace' => $e->getTrace(),
        ] : [];
        return new \support\Response(ResultCode::from($e->getCode()), $e->getMessage(), $data, $statusCode);
    }

    protected function renderOtherException(Request $request, Throwable $e): Response
    {
        $data = config('app.debug') ? [
            'file'  => $e->getFile(),
            'line'  => $e->getLine(),
            'trace' => $e->getTrace(),
        ] : [];
        return new \support\Response(ResultCode::UNKNOWN, $e->getMessage(), $data, 500);
    }
}
