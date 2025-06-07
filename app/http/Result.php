<?php

namespace app\http;


use Hyperf\Contract\Arrayable;

class Result implements Arrayable
{
    /**
     * @template T
     */
    public function __construct(
        public ResultCode $code = ResultCode::SUCCESS,
        public ?string    $message = null,
        public mixed      $data = []
    )
    {
        if ($this->message === null) {
            $this->message = ResultCode::getMessage($this->code->value);
        }
    }

    public function toArray(): array
    {
        return [
            'code'    => $this->code->value,
            'message' => $this->message,
            'data'    => $this->data,
        ];
    }

}
