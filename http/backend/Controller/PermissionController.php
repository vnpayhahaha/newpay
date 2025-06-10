<?php

namespace http\backend\Controller;

use app\controller\BasicController;
use app\middleware\AccessTokenMiddleware;
use app\model\enums\MenuStatus;
use app\model\enums\RoleStatus;
use app\repository\MenuRepository;
use app\repository\RoleRepository;
use app\router\Annotations\GetMapping;
use app\router\Annotations\Middleware;
use app\router\Annotations\RestController;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/backend/permission")]
#[Middleware(AccessTokenMiddleware::class)]
class PermissionController extends BasicController
{

    #[Inject]
    protected MenuRepository $menuRepository;

    #[Inject]
    protected RoleRepository $roleRepository;

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
}
