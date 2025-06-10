<?php

namespace http\backend\Controller;

use app\controller\BasicController;
use app\lib\enum\ResultCode;
use app\middleware\AccessTokenMiddleware;
use app\router\Annotations\GetMapping;
use app\router\Annotations\Middleware;
use app\router\Annotations\PostMapping;
use app\router\Annotations\RestController;
use app\service\RoleService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

#[RestController("/admin")]
#[Middleware(AccessTokenMiddleware::class)]
class RoleController extends BasicController
{

    #[Inject]
    protected RoleService $service;


    #[GetMapping('/role/list')]
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
    #[PostMapping('/role')]
    public function create(Request $request): Response
    {
        $validator = validate($request->all(), [
            'name'   => 'required|string|max:60',
            'code'   => [
                'required',
                'string',
                'max:60',
                'regex:/^[a-zA-Z0-9_]+$/',
                function ($attribute, $value, $fail) {
                    if ($this->service->repository->getModel()->where($attribute, $value)->exists()) {
                        $fail(trans('unique', [':attribute' => $attribute], 'validation'));
                    }
                }
            ],
            'status' => 'sometimes|integer|in:1,2',
            'sort'   => 'required|integer',
            'remark' => 'nullable|string|max:255',
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

}
