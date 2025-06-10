<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace support;

use app\lib\enum\ResultCode;
use Hyperf\Contract\Arrayable;
use Webman\Http\Request;

/**
 * Class Response
 * @package support
 */
class Response extends \Webman\Http\Response implements Arrayable
{

    /**
     * @template T
     */
    public function __construct(
        public ResultCode $code = ResultCode::SUCCESS,
        public ?string    $message = null,
        public mixed      $data = [],
        public int        $httpStatus = 200
    )
    {
        if ($this->message === null) {
            $this->message = ResultCode::getMessage($this->code->value);
        }
        parent::__construct($httpStatus, ['Content-Type' => 'application/json'], json_encode($this->toArray()));
    }

    public function toArray(): array
    {
        $request = Context::get(Request::class);
        $result =  [
            'request_id' => $request->requestId,
            'path'       => $request->path(),
            'success'    => $this->code->value === ResultCode::SUCCESS->value,
            'code'       => $this->code->value,
            'message'    => $this->message,
        ];
        if (filled($this->data)) {
            $result['data'] = $this->data;
        }
        return $result;
    }
}
