<?php

namespace http\tenant\controller;

use app\controller\BasicController;
use app\lib\annotation\NoNeedLogin;
use app\lib\enum\ResultCode;
use app\router\Annotations\GetMapping;
use app\router\Annotations\PostMapping;
use app\router\Annotations\RestController;
use app\service\TenantService;
use DI\Attribute\Inject;
use http\tenant\Service\PassportService;
use Illuminate\Support\Arr;
use support\Context;
use support\Request;
use support\Response;

#[RestController("/tenant/passport")]
class PassportController extends BasicController
{
    #[Inject]
    protected PassportService $passportService;
    #[Inject]
    protected TenantService $tenantService;

    #[PostMapping('/login')]
    #[NoNeedLogin]
    public function login(Request $request): Response
    {
        $validator = validate($request->all(), [
            'username'  => 'required|string|max:20',
            'tenant_id' => [
                'required',
                'string',
                'max:20',
                // 'exists:tenant,id',
                function ($attribute, $value, $fail) {
                    if (!$this->tenantService->repository->getModel()->where('tenant_id', $value)->exists()) {
                        $fail(trans('exists', [':attribute' => $attribute], 'validation'));
                    }
                },
            ],
            'password'  => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            return $this->error(ResultCode::FAIL, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $username = (string)$validatedData['username'];
        $password = (string)$validatedData['password'];
        $browser = $request->header('User-Agent') ?: 'unknown';
        $os = $request->os();
        $result = $this->passportService->login(
            $username,
            $password,
            (string)$validatedData['tenant_id'],
            $request->getRealIp(false),
            $browser,
            $os
        );

        return $this->success($result);
    }

    #[PostMapping('/logout')]
    public function logout(Request $request): Response
    {

        $token = Context::get('token');
        if (!$token) {
            return $this->error(ResultCode::FAIL, 'Logout failed');
        }
        $isLogout = $this->passportService->logout($token);
        if (!$isLogout) {
            return $this->error(ResultCode::FAIL, 'Logout failed');
        }
        return $this->success();
    }

    #[GetMapping('/getInfo')]
    public function getInfo(Request $request): Response
    {
        $user = $request->user;
        return $this->success(Arr::only(
            $user?->toArray() ?: [],
            ['username', 'nickname', 'avatar', 'backend_setting', 'phone']
        ));
    }

}
