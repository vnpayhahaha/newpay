<?php

namespace app\middleware;

use app\event\Dto\OperationEventDto;
use app\lib\annotation\OperationLog;
use app\lib\annotation\Permission;
use app\lib\JwtAuth\facade\JwtAuth;
use app\service\MenuService;
use support\Container;
use support\Context;
use support\Log;
use Webman\Event\Event;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class OperationLogMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        $response = $handler($request);
        $controllerClass = $request->controller;
        $action = $request->action;
        if ($controllerClass && $action) {
            try {
                $reflectionClass = new \ReflectionClass($controllerClass);
                // 检查方法级别的注解
                if ($reflectionClass->hasMethod($action)) {
                    $reflectionMethod = $reflectionClass->getMethod($action);

                    if ($methodAnnotation = $reflectionMethod->getAttributes(OperationLog::class)[0] ?? null) {
                        // 获取注解参数
                        $isDownload = false;
                        if (!empty($response->getHeader('content-description')) && !empty($response->getHeader('content-transfer-encoding'))) {
                            $isDownload = true;
                        }
                        $annotationPermission = $reflectionMethod->getAttributes(Permission::class)[0] ?? null;
                        $annotationPermissionCode = '';
                        if ($annotationPermission) {
                            $annotationPermissionCode = $annotationPermission->getArguments()[0] ?? '';
                        }
                        Event::dispatch('operation.log', new OperationEventDto($this->getRequestInfo($request, [
                            'code'          => !empty($annotationPermissionCode) ? explode(',', $annotationPermissionCode)[0] : '',
                            'name'          => $methodAnnotation->getArguments()[0] ?? '',
                            'response_code' => $response->getStatusCode(),
                            'response_data' => $isDownload ? '文件下载' : $response->rawBody(),
                        ])));
                    }
                }
            } catch (\Throwable $e) {
                // 记录错误日志但不中断请求
                Log::error('Failed to process operation log: ' . $e->getMessage());
            }
        }

        return $response;
    }

    protected function getRequestInfo(Request $request, array $data): array
    {

        $ip = $request->getRealIp(false);
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            // echo "$ip 是一个有效的IPv4地址";
            $ipLocation = $ip;
        } else {
            // echo "$ip 不是一个有效的IPv4地址";
            $ipLocation = '--';
        }
        $is_success = $data['response_data']['success'] ?? false;
        $operationLog = [
            'time'            => date('Y-m-d H:i:s'),
            'method'          => $request->method(),
            'router'          => $request->path(),
            'ip'              => $ip,
            'ip_location'     => $ipLocation,
            'service_name'    => $data['name'] ?: $this->getOperationMenuName($data['code']),
            'request_params'  => json_encode($request->all()),
            'response_status' => $data['response_code'],
            'response_data'   => $data['response_data'],
            'is_success'      => $data['response_code'] == 200 && $is_success,
        ];
        try {
            $token = Context::get('token') ?? '';
            JwtAuth::parseToken($token);
            $loginUser = JwtAuth::getUser();
            $operationLog['username'] = $loginUser->username;
            $operationLog['operator_id'] = $loginUser->id;
        } catch (\Exception $e) {
            $operationLog['username'] = trans('no_login_user', [], 'jwt');
        }

        return $operationLog;
    }

    /**
     * 获取菜单名称.
     */
    protected function getOperationMenuName(string $code): string
    {

        var_dump('==getOperationMenuName==', $code);
        return Container::get(MenuService::class)->findNameByCode($code);
    }

}
