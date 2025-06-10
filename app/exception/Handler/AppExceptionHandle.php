<?php

namespace app\exception\Handler;

use app\lib\enum\ResultCode;
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
        ] : null;
        return new \support\Response(ResultCode::from($e->getCode()), $e->getMessage(), $data, $statusCode);
    }

    protected function renderOtherException(Request $request, Throwable $e): Response
    {
        $data = config('app.debug') ? [
            'file'  => $e->getFile(),
            'line'  => $e->getLine(),
            'trace' => $e->getTrace(),
        ] : null;

        $getCode = intval($e->getCode());
        $statusCode = 500;
        if (in_array($getCode, [500, 501, 502, 503, 400, 401, 403, 404, 405, 406, 408, 409, 422])) {
            $statusCode = $getCode;
        }
        return match ($statusCode) {
            400 => new \support\Response(ResultCode::BAD_REQUEST, $e->getMessage(), $data, $statusCode),
            401 => new \support\Response(ResultCode::UNAUTHORIZED, $e->getMessage(), $data, $statusCode),
            403 => new \support\Response(ResultCode::FORBIDDEN, $e->getMessage(), $data, $statusCode),
            404 => new \support\Response(ResultCode::NOT_FOUND, $e->getMessage(), $data, $statusCode),
            405 => new \support\Response(ResultCode::METHOD_NOT_ALLOWED, $e->getMessage(), $data, $statusCode),
            406 => new \support\Response(ResultCode::NOT_ACCEPTABLE, $e->getMessage(), $data, $statusCode),
            408 => new \support\Response(ResultCode::REQUEST_TIMEOUT, $e->getMessage(), $data, $statusCode),
            409 => new \support\Response(ResultCode::CONFLICT, $e->getMessage(), $data, $statusCode),
            422 => new \support\Response(ResultCode::UNPROCESSABLE_ENTITY, $e->getMessage(), $data, $statusCode),
            default => new \support\Response(ResultCode::UNKNOWN, $e->getMessage(), $data, $statusCode),
        };
    }
}
