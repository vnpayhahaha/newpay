<?php

namespace http\backend\Controller;

use app\controller\BasicController;
use app\lib\annotation\Permission;
use app\router\Annotations\DeleteMapping;
use app\router\Annotations\GetMapping;
use app\router\Annotations\RestController;
use app\service\UserLoginLogService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin")]
class UserLoginLogController extends BasicController
{
    #[Inject]
    protected UserLoginLogService $service;

    #[GetMapping('/user-login-log/list')]
    #[Permission(code: 'log:userLogin:list')]
    public function pageList(Request $request): Response
    {
        return $this->success(
            data: $this->service->page(
                $request->all(),
                $this->getCurrentPage(),
                $this->getPageSize(),
            )
        );
    }

    // delete
    #[DeleteMapping('/user-login-log')]
    #[Permission(code: 'log:userLogin:delete')]
    public function delete(Request $request): Response
    {
        $this->service->deleteById($request->input('ids'));
        return $this->success();
    }

}
