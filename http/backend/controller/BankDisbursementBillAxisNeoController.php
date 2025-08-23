<?php

namespace http\backend\controller;

use app\controller\BasicController;
use app\lib\annotation\OperationLog;
use app\lib\annotation\Permission;
use app\router\Annotations\GetMapping;
use app\router\Annotations\RestController;
use app\service\BankDisbursementBillAxisNeftService;
use app\service\BankDisbursementBillAxisNeoService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin/bank_bill")]
class BankDisbursementBillAxisNeoController extends BasicController
{
    #[Inject]
    protected BankDisbursementBillAxisNeoService $service;

    #[GetMapping('/axis_neo/list')]
    #[Permission(code: 'bank_bill:axis_neo:list')]
    public function pageList(Request $request): Response
    {
        return $this->success(
            $this->service->page($request->all(), $this->getCurrentPage(), $this->getPageSize())
        );
    }
}