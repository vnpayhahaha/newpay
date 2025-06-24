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
use app\service\TenantService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin/tenant")]
class TenantController extends BasicController
{
    #[Inject]
    protected TenantService $service;

    #[GetMapping('/tenant/list')]
    #[Permission(code: 'tenant:tenant:list')]
    #[OperationLog('租户管理列表')]
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

    // 单个或批量真实删除数据 （清空回收站）
    #[DeleteMapping('/tenant/realDelete')]
    #[Permission(code: 'tenant:tenant:realDelete')]
    #[OperationLog('清空回收站')]
    public function realDelete(Request $request): Response
    {
        return $this->service->realDelete((array)$request->all()) ? $this->success() : $this->error();
    }

    // 单个或批量恢复在回收站的数据
    #[PutMapping('/tenant/recovery')]
    #[Permission(code: 'tenant:tenant:recovery')]
    #[OperationLog('租户回收站恢复')]
    public function recovery(Request $request): Response
    {
        return $this->service->recovery((array)$request->input('ids', [])) ? $this->success() : $this->error();
    }

    #[PostMapping('/tenant')]
    #[Permission(code: 'tenant:tenant:create')]
    #[OperationLog('创建租户')]
    public function create(Request $request): Response
    {
        $validator = validate($request->all(), [
            'company_name'      => 'required|string|max:200',
            'contact_user_name' => 'required|string|max:20',
            'contact_phone'     => 'required|string|max:20',
            'account_count'     => ['required', 'integer', 'between:-1,99'],
            'is_enabled'        => ['required', 'boolean'],
            'safe_level'        => ['required', 'integer', 'between:0,99'],
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

    #[PutMapping('/tenant/{id}')]
    #[Permission(code: 'tenant:tenant:update')]
    #[OperationLog('编辑租户')]
    public function update(Request $request, int $id): Response
    {
        $validator = validate($request->all(), [
            'contact_user_name' => 'required|string|max:20',
            'contact_phone'     => 'required|string|max:20',
            'company_name'      => 'required|string|max:200',
            'account_count'     => 'required|integer|between:-1,99',
            'is_enabled'        => ['required', 'boolean'],
            'safe_level'        => ['required', 'integer', 'between:0,99'],
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
    #[DeleteMapping('/tenant')]
    #[Permission(code: 'tenant:tenant:delete')]
    #[OperationLog('删除租户')]
    public function delete(Request $request): Response
    {
        $this->service->deleteById($request->all());
        return $this->success();
    }

    #[GetMapping('/tenantDict/remote')]
    public function remote(Request $request): Response
    {
        $fields = [
            'id',
            'tenant_id',
            'contact_user_name',
            'is_enabled',
            'created_by',
            'expired_at',
        ];
        return $this->success(
            $this->service->getList([])->map(static fn($user) => $user->only($fields))
        );
    }

}
