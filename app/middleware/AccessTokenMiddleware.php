<?php

namespace app\middleware;

use app\lib\JwtAuth\exception\JwtException;
use app\lib\JwtAuth\facade\JwtAuth;
use app\lib\JwtAuth\handle\RequestToken;
use support\Context;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class AccessTokenMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $next): Response
    {
        if ($request->method() === 'OPTIONS') {
            response('', 204);
        }
        if ($route = $request->route) {
            $store = $route->param('store');
        }
        $store = $store ?? (\request()->app === '' ? 'default' : \request()->app);
        try {
            $requestToken = new RequestToken();
            $handel = JwtAuth::getConfig($store)->getType();
            $token = $requestToken->get($handel);
            JwtAuth::verify($token);
            $request->user = JwtAuth::getUser();
            Context::set('token',$token);
            return $next($request);
        } catch (JwtException $e) {
            throw new JwtException($e->getMessage(), $e->getCode());
        }
    }

}
