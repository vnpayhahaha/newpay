<?php

namespace http\backend\controller;

use app\controller\BasicController;
use app\exception\UnprocessableEntityException;
use app\lib\annotation\OperationLog;
use app\lib\annotation\Permission;
use app\lib\enum\ResultCode;
use app\router\Annotations\DeleteMapping;
use app\router\Annotations\GetMapping;
use app\router\Annotations\PostMapping;
use app\router\Annotations\PutMapping;
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

    // create
    #[PostMapping('/transaction_parsing_rules')]
    #[Permission(code: 'transaction:transaction_parsing_rules:create')]
    #[OperationLog('创建凭证解析规则')]
    public function create(Request $request): Response
    {
        $validator = validate($request->all(), [
            'channel_id'      => 'required|integer|max:999999',
            'example_data'    => 'required|string',
            'regex'           => 'required|string|max:255',
            'status'          => [
                'required',
                'boolean'
            ],
            'variable_name'   => [
                'required',
                'array'
            ],
            'variable_name.*' => [
                'required',
                'string'
            ],
        ]);
        if ($validator->fails()) {
            throw new UnprocessableEntityException(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $this->service->create($validatedData);
        return $this->success();
    }

    // 编辑
    #[PutMapping('/transaction_parsing_rules/{id}')]
    #[Permission(code: 'transaction:transaction_parsing_rules:update')]
    #[OperationLog('编辑交易解析规则')]
    public function update(Request $request, int $id): Response
    {
        $validator = validate($request->all(), [
            'channel_id'      => 'required|integer|max:999999',
            'example_data'    => 'required|string',
            'regex'           => 'required|string|max:255',
            'status'          => [
                'required',
                'boolean'
            ],
            'variable_name'   => [
                'required',
                'array'
            ],
            'variable_name.*' => [
                'required',
                'string'
            ],
        ]);
        if ($validator->fails()) {
            throw new UnprocessableEntityException(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $this->service->updateById($id, $validatedData);
        return $this->success();
    }

    // DeleteMapping
    #[DeleteMapping('/transaction_parsing_rules')]
    #[Permission(code: 'transaction:transaction_parsing_rules:delete')]
    #[OperationLog('删除交易解析规则')]
    public function delete(Request $request): Response
    {
        $this->service->deleteById($request->all());
        return $this->success();
    }
}
