<?php

namespace http\backend\Controller;

use app\controller\BasicController;
use app\exception\BusinessException;
use app\lib\enum\ResultCode;
use app\middleware\AccessTokenMiddleware;
use app\model\enums\MenuStatus;
use app\model\enums\RoleStatus;
use app\repository\MenuRepository;
use app\repository\RoleRepository;
use app\router\Annotations\GetMapping;
use app\router\Annotations\Middleware;
use app\router\Annotations\PostMapping;
use app\router\Annotations\RestController;
use app\service\UserService;
use DI\Attribute\Inject;
use Illuminate\Support\Arr;
use support\Request;
use support\Response;

#[RestController("/admin/permission")]
#[Middleware(AccessTokenMiddleware::class)]
class PermissionController extends BasicController
{

    #[Inject]
    protected MenuRepository $menuRepository;

    #[Inject]
    protected RoleRepository $roleRepository;

    #[Inject]
    protected UserService $userService;

    #[GetMapping('/menus')]
    public function menus(Request $request): Response
    {
        return $this->success(
            data: $request->user->isSuperAdmin()
                ? $this->menuRepository->list([
                    'status'    => MenuStatus::Normal,
                    'children'  => true,
                    'parent_id' => 0,
                ])
                : $request->user->filterCurrentUser()
        );
    }

    #[GetMapping('/roles')]
    public function roles(Request $request): Response
    {
        return $this->success(
            data: $request->user->isSuperAdmin()
                ? $this->roleRepository->list(['status' => RoleStatus::Normal])
                : $request->user->getRoles(['name', 'code', 'remark'])
        );
    }

    #[PostMapping('/roles')]
    public function update(Request $request): Response
    {
        $validator = validate($request->post(), [
            'nickname'                  => 'sometimes|string|max:255',
            'new_password'              => 'sometimes|confirmed|string|min:8',
            'new_password_confirmation' => 'sometimes|string|min:8',
            'old_password'              => ['sometimes', 'string'],
            'avatar'                    => 'sometimes|string|max:255',
            'signed'                    => 'sometimes|string|max:255',
            'backend_setting'           => 'sometimes|array',
        ]);
        if ($validator->fails()) {
            return $this->error(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $user = $request->user;
        if (Arr::exists($validatedData, 'new_password')) {
            if (!$user->verifyPassword(Arr::get($validatedData, 'old_password'))) {
                throw new BusinessException(ResultCode::UNPROCESSABLE_ENTITY, trans('old_password_error', [], 'user'));
            }
            $validatedData['password'] = $validatedData['new_password'];
        }
        $this->userService->updateById($user->id, $validatedData);
        return $this->success();
    }
}
