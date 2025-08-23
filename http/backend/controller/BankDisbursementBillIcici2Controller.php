<?php

namespace http\backend\controller;

use app\controller\BasicController;
use app\lib\annotation\Permission;
use app\router\Annotations\GetMapping;
use app\router\Annotations\RestController;
use app\service\BankDisbursementBillIcici2Service;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin/bank_bill")]
class BankDisbursementBillIcici2Controller extends BasicController
{
    #[Inject]
    protected BankDisbursementBillIcici2Service $service;

    #[GetMapping('/icic2/list')]
    #[Permission(code: 'bank_bill:icic2:list')]
    public function pageList(Request $request): Response
    {
        return $this->success(
            $this->service->page($request->all(), $this->getCurrentPage(), $this->getPageSize())
        );
    }
}