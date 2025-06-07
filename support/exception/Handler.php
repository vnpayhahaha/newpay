<?php

namespace support\exception;

use Throwable;
use Webman\Exception\ExceptionHandlerInterface;
use Webman\Http\Request;
use Webman\Http\Response;

class Handler implements ExceptionHandlerInterface
{
    public function report(Throwable $exception)
    {
        // TODO: Implement report() method.
    }

    public function render(Request $request, Throwable $exception): Response
    {
        var_dump($exception);
        return \response($exception->getMessage(), 500);
    }

}
