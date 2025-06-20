<?php

namespace app\middleware;

use support\Log;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class CorsMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        // 如果是options请求则返回一个空响应，否则继续向洋葱芯穿越，并得到一个响应
        $response = $handler($request);
        // 设置基础跨域头
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With, Token',
            'Access-Control-Expose-Headers'    => 'Authorization, Token',
            'Access-Control-Allow-Credentials' => 'true', // 如果需要携带凭证
        ];
        // 处理OPTIONS预检请求
        if ($request->method() === 'OPTIONS') {
            $response = response('', 204);
            $response->withHeaders(array_merge($headers, [
                'Access-Control-Max-Age' => 1728000, // 20天缓存
            ]));
            return $response;
        }
        Log::info('CorsMiddleware  process');
        // 非OPTIONS请求添加跨域头
        $response->withHeaders($headers);
        return $response;
    }

}
