<?php

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class LangMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        $lang = $request->header('accept-language', 'zh_cn');
        locale($lang);
        return $handler($request);
    }

}
