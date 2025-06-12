<?php

namespace http\backend\Controller;

use app\controller\BasicController;
use app\lib\annotation\Permission;
use app\lib\enum\ResultCode;
use app\model\enums\PolicyType;
use app\model\ModelRole;
use app\router\Annotations\DeleteMapping;
use app\router\Annotations\GetMapping;
use app\router\Annotations\PostMapping;
use app\router\Annotations\PutMapping;
use app\router\Annotations\RestController;
use app\service\RoleService;
use app\service\UserService;
use DI\Attribute\Inject;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use support\Request;
use support\Response;

#[RestController("/admin")]
class UserController extends BasicController
{

    #[Inject]
    protected UserService $userService;

    #[Inject]
    protected RoleService $roleService;

    #[GetMapping('/user/list')]
    #[Permission(code: 'permission:user:index')]
    public function pageList(Request $request): Response
    {

        return $this->success(
            data: $this->userService->page(
                $request->all(),
                $this->getCurrentPage(),
                $this->getPageSize(),
            )
        );
    }

    #[PutMapping('/user')]
    #[Permission(code: 'permission:user:update')]
    public function updateInfo(Request $request): Response
    {
        $validator = validate($request->post(), [
            'username'           => 'required|string|max:20',
            'user_type'          => 'required|integer',
            'nickname'           => ['required', 'string', 'max:60', 'regex:/^[^\s]+$/'],
            'phone'              => 'sometimes|string|max:12',
            'email'              => 'sometimes|string|max:60|email:rfc,dns',
            'avatar'             => 'sometimes|string|max:255|url',
            'signed'             => 'sometimes|string|max:255',
            'status'             => 'sometimes|integer',
            'backend_setting'    => 'sometimes|array|max:255',
            'remark'             => 'sometimes|string|max:255',
            'policy'             => 'sometimes|array',
            'policy.policy_type' => [
                'required_with:policy',
                'string',
                'max:20',
                Rule::enum(PolicyType::class),
            ],
            'policy.value'       => [
                'sometimes',
            ],
            'department'         => [
                'sometimes',
                'array',
            ],
            'department.*'       => [
                'required_with:department',
                'integer',
                'exists:department,id',
            ],
            'position'           => [
                'sometimes',
                'array',
            ],
            'position.*'         => [
                'sometimes',
                'integer',
                'exists:position,id',
            ],
        ]);
        if ($validator->fails()) {
            return $this->error(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $this->userService->updateById($request->user->id, Arr::except($validatedData, ['password']));
        return $this->success();
    }

    /**
     * 重置密码
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Validation\ValidationException
     */
    #[PutMapping('/user/password')]
    #[Permission(code: 'permission:user:password')]
    public function resetPassword(Request $request): Response
    {
        $validator = validate($request->all(), [
            'id' => 'required|integer|between:1,4294967295',
        ]);
        if ($validator->fails()) {
            return $this->error(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        return $this->userService->resetPassword($validatedData['id'])
            ? $this->success()
            : $this->error();
    }

    // create
    #[PostMapping('/user')]
    #[Permission(code: 'permission:user:save')]
    public function create(Request $request): Response
    {
        $validator = validate($request->all(), [
            'username'              => 'required|string|max:20',
            'user_type'             => 'required|integer',
            'nickname'              => ['required', 'string', 'max:60', 'regex:/^[^\s]+$/'],
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required| min:6 | max:20',
            'phone'                 => 'sometimes|string|max:12',
            'email'                 => 'sometimes|string|max:60|email:rfc,dns',
            'avatar'                => 'sometimes|string|max:255|url',
        ]);
        if ($validator->fails()) {
            return $this->error(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $this->userService->create(array_merge(
            $validatedData,
            [
                'created_by' => $request->user->id,
            ]
        ));
        return $this->success();
    }

    // save
    #[PutMapping('/user/{userId}')]
    #[Permission(code: 'permission:user:update')]
    public function save(Request $request, int $userId): Response
    {
        $validator = validate($request->all(), [
            'username'  => 'required|string|max:20',
            'user_type' => 'required|integer',
            'nickname'  => ['required', 'string', 'max:60', 'regex:/^[^\s]+$/'],
            'phone'     => 'sometimes|string|max:12',
            'email'     => 'sometimes|string|max:60|email:rfc,dns',
            'avatar'    => 'sometimes|string|max:255|url',
        ]);
        if ($validator->fails()) {
            return $this->error(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $this->userService->updateById($userId, array_merge(
            $validatedData,
            [
                'updated_by' => $request->user->id,
            ]
        ));
        return $this->success();
    }

    // delete
    #[DeleteMapping('/user')]
    #[Permission(code: 'permission:user:delete')]
    public function delete(Request $request): Response
    {
        $this->userService->deleteById($request->all());
        return $this->success();
    }

    // 获取用户角色列表
    #[GetMapping('/user/{userId}/roles')]
    #[Permission(code: 'permission:user:getRole')]
    public function getUserRoles(int $userId): Response
    {
        return $this->success($this->userService->getUserRoles($userId)->map(static fn(ModelRole $role) => $role->only([
            'id',
            'code',
            'name',
        ])));
    }

    // 批量授权用户角色
    #[PutMapping('/user/{userId}/roles')]
    #[Permission(code: 'permission:user:setRole')]
    public function batchGrantUserRoles(Request $request, int $userId): Response
    {
        $validator = validate($request->all(), [
            'role_codes'   => 'required|array',
            'role_codes.*' => [
                'string',
                function ($attribute, $value, $fail) {
                    if (!$this->roleService->repository->getModel()->where('code', $value)->exists()) {
                        $fail(trans('exists', [':attribute' => $attribute], 'validation'));
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return $this->error(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $this->userService->batchGrantRoleForUser($userId, $validatedData['role_codes']);
        return $this->success();
    }
}
