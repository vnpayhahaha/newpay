<?php

namespace http\backend\Controller;

use app\controller\BasicController;
use app\middleware\AccessTokenMiddleware;
use app\router\Annotations\GetMapping;
use app\router\Annotations\Middleware;
use app\router\Annotations\RestController;
use app\service\UserService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin/user")]
#[Middleware(AccessTokenMiddleware::class)]
class UserController extends BasicController
{

    #[Inject]
    protected UserService $userService;

    #[GetMapping('/list')]
    public function pageList(Request $request): Response
    {

        return $this->success(
            data: $this->userService->page(
                $request->all(),
                $this->getCurrentPage(),
                $this->getPageSize(),
            )
        );
    }
}
