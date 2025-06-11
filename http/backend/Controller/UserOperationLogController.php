<?php

namespace http\backend\Controller;

use app\controller\BasicController;
use app\middleware\AccessTokenMiddleware;
use app\router\Annotations\DeleteMapping;
use app\router\Annotations\GetMapping;
use app\router\Annotations\Middleware;
use app\router\Annotations\RestController;
use app\service\UserOperationLogService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin")]
#[Middleware(AccessTokenMiddleware::class)]
class UserOperationLogController extends BasicController
{
    #[Inject]
    protected UserOperationLogService $service;

    #[GetMapping('/user-operation-log/list')]
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

    #[DeleteMapping('/user-operation-log')]
    public function delete(Request $request): Response
    {
        $this->service->deleteById($request->input('ids'));
        return $this->success();
    }

}
