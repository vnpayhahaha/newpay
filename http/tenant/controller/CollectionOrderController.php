<?php

namespace http\tenant\controller;

use app\controller\BasicController;
use app\lib\annotation\OperationLog;
use app\lib\annotation\Permission;
use app\router\Annotations\GetMapping;
use app\router\Annotations\RestController;
use app\service\CollectionOrderService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/tenant/transaction")]
class CollectionOrderController extends BasicController
{
    #[Inject]
    protected CollectionOrderService $service;

    #[GetMapping('/collection_order/list')]
    #[Permission(code: 'transaction:collection_order:list')]
    #[OperationLog('收款订单列表')]
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
}
