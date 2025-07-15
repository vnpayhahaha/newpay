<?php

namespace http\tenant\controller;

use app\controller\BasicController;
use app\exception\UnprocessableEntityException;
use app\lib\enum\ResultCode;
use app\router\Annotations\GetMapping;
use app\router\Annotations\PostMapping;
use app\router\Annotations\RestController;
use app\service\TenantUserService;
use DI\Attribute\Inject;
use Illuminate\Support\Arr;
use support\Request;
use support\Response;

#[RestController("/tenant/permission")]
class PermissionController extends BasicController
{
    #[Inject]
    protected TenantUserService $userService;
    #[GetMapping('/menus')]
    public function menus(Request $request): Response
    {
        return $this->success([]);
    }

    #[GetMapping('/roles')]
    public function roles(Request $request): Response
    {
        return $this->success([]);
    }

    #[PostMapping('/update')]
    public function update(Request $request): Response
    {
        $validator = validate($request->post(), [
            'new_password'              => 'sometimes|confirmed|string|min:8',
            'new_password_confirmation' => 'sometimes|string|min:8',
            'old_password'              => ['sometimes', 'string'],
            'avatar'                    => 'sometimes|string|max:255',
            'backend_setting'           => 'sometimes|array',
        ]);
        if ($validator->fails()) {
            throw new UnprocessableEntityException(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $user = $request->user;
        if (Arr::exists($validatedData, 'new_password')) {
            if (!$user->verifyPassword(Arr::get($validatedData, 'old_password'))) {
                throw new UnprocessableEntityException(ResultCode::UNPROCESSABLE_ENTITY, trans('old_password_error', [], 'user'));
            }
            $validatedData['password'] = $validatedData['new_password'];
        }
        $this->userService->updateById($user->id, $validatedData);
        return $this->success();
    }
}
