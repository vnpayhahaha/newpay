<?php

namespace http\backend\controller;

use app\controller\BasicController;
use app\lib\annotation\OperationLog;
use app\lib\annotation\Permission;
use app\router\Annotations\GetMapping;
use app\router\Annotations\RestController;
use app\service\TransactionParsingRulesService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin/transaction")]
class TransactionParsingRulesController extends BasicController
{
    #[Inject]
    protected TransactionParsingRulesService $service;

    #[GetMapping('/transaction_parsing_rules/list')]
    #[Permission(code: 'transaction:transaction_parsing_rules:list')]
    #[OperationLog('凭证解析规则列表')]
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
