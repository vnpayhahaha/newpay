<?php

namespace http\tenant\controller;

use app\controller\BasicController;
use app\lib\annotation\NoNeedLogin;
use app\lib\enum\ResultCode;
use app\model\enums\UserType;
use app\router\Annotations\PostMapping;
use app\router\Annotations\RestController;
use app\service\TenantService;
use DI\Attribute\Inject;
use http\tenant\Service\PassportService;
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
        $validator = validate($request->post(), [
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

}
