<?php

namespace http\backend\Controller;

use app\controller\BasicController;
use app\lib\enum\ResultCode;
use app\middleware\AccessTokenMiddleware;
use app\model\enums\PolicyType;
use app\router\Annotations\GetMapping;
use app\router\Annotations\Middleware;
use app\router\Annotations\PutMapping;
use app\router\Annotations\RestController;
use app\service\UserService;
use DI\Attribute\Inject;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use support\Request;
use support\Response;

#[RestController("/admin")]
#[Middleware(AccessTokenMiddleware::class)]
class UserController extends BasicController
{

    #[Inject]
    protected UserService $userService;

    #[GetMapping('/user/list')]
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
     */
    #[PutMapping('/user/password')]
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
}
