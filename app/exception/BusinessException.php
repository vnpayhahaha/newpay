<?php

namespace app\exception;

use app\http\ResultCode;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BusinessException extends HttpException
{

    protected mixed $data;
    public function __construct(ResultCode $code = ResultCode::FAIL, ?string $message = null, mixed $data = [])
    {
        $this->code = $code->value;
        $this->message = $message;
        if ($message === null) {
            var_dump('==s=s=');
            $this->message = ResultCode::getMessage($code->value);
        }
        $this->data = $data;
        parent::__construct(500, $this->message,null,  [],$this->code);
    }

}

