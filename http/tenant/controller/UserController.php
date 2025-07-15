<?php

namespace http\tenant\controller;

use app\controller\BasicController;
use app\router\Annotations\GetMapping;
use app\router\Annotations\RestController;
use app\service\TenantUserService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/tenant")]
class UserController  extends BasicController
{
    #[Inject]
    protected TenantUserService $userService;
    #[GetMapping('/userDict/remote')]
    public function remote(Request $request): Response
    {
        $fields = [
            'id',
            'username',
            'status',
            'login_ip',
            'login_time',
        ];
        $user = $request->user;
        return $this->success(
            $this->userService->getList([
                'tenant_id' => $user->tenant_id,
            ])->map(static fn($user) => $user->only($fields))
        );
    }
}
