<?php

namespace app\middleware;

use app\lib\annotation\NoNeedLogin;
use app\lib\JwtAuth\exception\JwtException;
use app\lib\JwtAuth\facade\JwtAuth;
use app\lib\JwtAuth\handle\RequestToken;
use support\Context;
use support\Log;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class AccessTokenMiddleware implements MiddlewareInterface
{

    public function process(Request $request, callable $handler): Response
    {
        if ($request->method() === 'OPTIONS') {
            response('', 204);
        }
        $controllerClass = $request->controller;
        $action = $request->action;
        if ($controllerClass && $action) {
            try {
                $reflectionClass = new \ReflectionClass($controllerClass);
                // 检查方法级别的注解
                if ($reflectionClass->hasMethod($action)) {
                    $reflectionMethod = $reflectionClass->getMethod($action);
                    $methodAnnotation = $reflectionMethod->getAttributes(NoNeedLogin::class);
                    if (!empty($methodAnnotation)) {
                        return $handler($request);
                    }
                }
            } catch (\Throwable $e) {
                // 记录错误日志但不中断请求
                Log::error('Failed to process AccessTokenMiddleware: ' . $e->getMessage());
            }
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
            Context::set('token', $token);
            return $handler($request);
        } catch (JwtException $e) {
            throw new JwtException($e->getMessage(), $e->getCode());
        }
    }

}
