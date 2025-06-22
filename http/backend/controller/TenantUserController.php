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
use app\service\TenantUserService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin/tenant")]
class TenantUserController extends BasicController
{
    #[Inject]
    protected TenantUserService $service;

    #[GetMapping('/tenant_user/list')]
    #[Permission(code: 'tenant:tenant_user:list')]
    #[OperationLog('租户成员列表')]
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

    #[PostMapping('/tenant_user')]
    #[Permission(code: 'tenant:tenant_user:create')]
    #[OperationLog('添加租户成员')]
    public function create(Request $request): Response
    {
        $validator = validate($request->all(), [
            'tenant_id'         => 'required|string|max:20',
            'username'          => 'required|string|max:50',
            'phone'             => 'required|string|max:20',
            'status'            => ['required', 'integer', 'between:1,2'],
            'is_enabled_google' => ['required', 'integer', 'between:1,2'],
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

    #[PutMapping('/tenant_user/password')]
    #[Permission(code: 'tenant:tenant_user:update')]
    #[OperationLog('重置租户成员密码')]
    public function password(Request $request): Response
    {
        $validator = validate($request->all(), [
            'id' => 'required|integer|between:1,4294967295',
        ]);
        if ($validator->fails()) {
            return $this->error(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        return $this->service->resetPassword($validatedData['id'])
            ? $this->success()
            : $this->error();
    }

    #[PutMapping('/tenant_user/{id}')]
    #[Permission(code: 'tenant:tenant_user:update')]
    #[OperationLog('编辑租户成员')]
    public function update(Request $request, int $id): Response
    {
        $validator = validate($request->all(), [
            'tenant_id'         => 'required|string|max:20',
            'username'          => 'required|string|max:50',
            'phone'             => 'required|string|max:20',
            'status'            => ['required', 'integer', 'between:1,2'],
            'is_enabled_google' => ['required', 'integer', 'between:1,2'],
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

    #[DeleteMapping('/tenant_user')]
    #[Permission(code: 'tenant:tenant_user:delete')]
    #[OperationLog('删除租户成员')]
    public function delete(Request $request): Response
    {
        $this->service->deleteById($request->all());
        return $this->success();
    }

}
