<?php

namespace http\backend\controller;

use app\controller\BasicController;
use app\lib\annotation\Permission;
use app\router\Annotations\GetMapping;
use app\router\Annotations\RestController;
use app\service\BankDisbursementBillAxisService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin/bank_bill")]
class BankDisbursementBillAxisController extends BasicController
{
    #[Inject]
    protected BankDisbursementBillAxisService $service;

    #[GetMapping('/axis/list')]
    #[Permission(code: 'bank_bill:axis:list')]
    public function pageList(Request $request): Response
    {
        return $this->success(
            $this->service->page($request->all(), $this->getCurrentPage(), $this->getPageSize())
        );
    }
}