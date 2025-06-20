<?php

namespace app\middleware;

use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class CorsMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        // 如果是options请求则返回一个空响应，否则继续向洋葱芯穿越，并得到一个响应
        $response = $handler($request);

        // 设置跨域响应头
        $response->withHeaders([
//            'Access-Control-Allow-Credentials' => 'true',// 如果需要携带cookie等凭证信息
            'Access-Control-Allow-Origin'      => '*', // 允许所有域名访问，生产环境应指定具体域名
            'Access-Control-Allow-Methods'     => 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With, Token',
            'Access-Control-Expose-Headers'    => 'Authorization, Token',

        ]);
        if ($request->method() === 'OPTIONS') {
            //     'Access-Control-Max-Age'           => 1728000, // 预检请求缓存时间(秒)
            $response->withHeaders([
                'Access-Control-Max-Age'           => 1728000,
            ]);
            return response('', 204);
        }

        return $response;
    }

}
