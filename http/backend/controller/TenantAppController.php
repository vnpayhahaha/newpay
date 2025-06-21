<?php

namespace http\backend\controller;

use app\controller\BasicController;
use app\lib\annotation\OperationLog;
use app\lib\annotation\Permission;
use app\lib\enum\ResultCode;
use app\router\Annotations\DeleteMapping;
use app\router\Annotations\GetMapping;
use app\router\Annotations\PostMapping;
use app\router\Annotations\PutMapping;
use app\router\Annotations\RestController;
use app\service\TenantAppService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin/tenant")]
class TenantAppController extends BasicController
{
    #[Inject]
    protected TenantAppService $service;

    #[GetMapping('/tenant_app/list')]
    #[Permission(code: 'tenant:tenant_app:list')]
    #[OperationLog('租户应用管理列表')]
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

    #[PostMapping('/tenant_app')]
    #[Permission(code: 'tenant:tenant_app:create')]
    #[OperationLog('创建租户应用')]
    public function create(Request $request): Response
    {
        $validator = validate($request->all(), [
            'app_name'  => 'required|string|max:32',
            'remark'    => 'string|max:255',
            'tenant_id' => 'required|string|max:20',
            'status'    => ['required', 'integer', 'between:1,2'],
        ]);
        if ($validator->fails()) {
            return $this->error(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $this->service->create(array_merge(
            $validatedData,
            [
                'created_by' => $request->user->id,
            ]
        ));
        return $this->success();
    }

    #[PutMapping('/tenant_app/{id}')]
    #[Permission(code: 'tenant:tenant_app:update')]
    #[OperationLog('编辑租户应用')]
    public function update(Request $request, int $id): Response
    {
        $validator = validate($request->all(), [
            'app_name'  => 'required|string|max:32',
            'remark'    => 'string|max:255',
            'tenant_id' => 'required|string|max:20',
            'status'    => ['required', 'integer', 'between:1,2'],
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

    // 删除
    #[DeleteMapping('/tenant_app')]
    #[Permission(code: 'tenant:tenant_app:delete')]
    #[OperationLog('删除租户应用')]
    public function delete(Request $request): Response
    {
        $this->service->deleteById($request->all());
        return $this->success();
    }

}
