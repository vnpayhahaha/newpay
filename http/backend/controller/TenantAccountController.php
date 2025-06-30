<?php

namespace http\backend\controller;

use app\controller\BasicController;
use app\lib\annotation\OperationLog;
use app\lib\annotation\Permission;
use app\lib\enum\ResultCode;
use app\router\Annotations\GetMapping;
use app\router\Annotations\PutMapping;
use app\router\Annotations\RestController;
use app\service\TenantAccountService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin/tenant")]
class TenantAccountController extends BasicController
{
    #[Inject]
    protected TenantAccountService $service;

    #[GetMapping('/tenant_account/list')]
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

    #[PutMapping('/tenant_account/{id}')]
    #[Permission(code: 'tenant:tenant_account:update')]
    #[OperationLog('编辑租户账户')]
    public function update(Request $request, int $id): Response
    {
        $validator = validate($request->all(), [
            'account_type'  => ['required', 'integer', 'between:1,2'],
            'tenant_id' => 'required|string|max:20',
        ]);
        if ($validator->fails()) {
            return $this->error(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $this->service->updateById($id, array_merge(
            $validatedData,
            [
                'updated_by' => $request->user->id,
            ]
        ));
        return $this->success();
    }
}
