<?php

namespace http\backend\controller;

use app\controller\BasicController;
use app\lib\annotation\OperationLog;
use app\lib\annotation\Permission;
use app\router\Annotations\GetMapping;
use app\router\Annotations\RestController;
use app\service\TransactionRecordService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin/transaction")]
class TransactionRawDataController extends BasicController
{
    #[Inject]
    protected TransactionRecordService $service;

    #[GetMapping('/transaction_raw_data/list')]
    #[Permission(code: 'transaction:transaction_raw_data:list')]
    #[OperationLog('凭证原始数据列表')]
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
