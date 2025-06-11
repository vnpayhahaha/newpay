<?php

namespace http\backend\Controller;

use app\controller\BasicController;
use app\lib\enum\ResultCode;
use app\middleware\AccessTokenMiddleware;
use app\model\enums\PolicyType;
use app\router\Annotations\DeleteMapping;
use app\router\Annotations\GetMapping;
use app\router\Annotations\Middleware;
use app\router\Annotations\PostMapping;
use app\router\Annotations\PutMapping;
use app\router\Annotations\RestController;
use app\service\PositionService;
use DI\Attribute\Inject;
use Illuminate\Validation\Rule;
use support\Request;
use support\Response;

#[RestController("/admin")]
#[Middleware(AccessTokenMiddleware::class)]
class PositionController extends BasicController
{
    #[Inject]
    protected PositionService $service;

    #[GetMapping('/position/list')]
    public function pageList(Request $request): Response
    {
        return $this->success(
            $this->service->page(
                $request->all(),
                $this->getCurrentPage(),
                $this->getPageSize()
            )
        );
    }

    // batchDataPermission
    #[PutMapping('/position/{id}/data_permission')]
    public function dataPermissionListForPosition(Request $request, int $id): Response
    {
        $validator = validate($request->all(), [
            'policy_type' => [
                'required',
                'string',
                Rule::enum(PolicyType::class),
            ],
            'value'       => [
                'sometimes',
                'array',
                'min:1',
            ],
        ]);

        if ($validator->fails()) {
            return $this->error(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $this->service->batchDataPermission($id, $validatedData);
        return $this->success();
    }

    // create
    #[PostMapping('/position')]
    public function create(Request $request): Response
    {
        $validator = validate($request->all(), [
            'name'    => [
                'required',
                'string',
                'max:60',
                //'unique:position,name',
                function ($attribute, $value, $fail) {
                    if ($this->service->repository->getModel()->where($attribute, $value)->exists()) {
                        $fail(trans('unique', [':attribute' => $attribute], 'validation'));
                    }
                }

            ],
            'dept_id' => 'required|integer|exists:department,id',
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

    // save
    #[PutMapping('/position/{id}')]
    public function save(Request $request, int $id): Response
    {
        $validator = validate($request->all(), [
            'name' => [
                'required',
                'string',
                'max:60',
                //'unique:position,name',
                function ($attribute, $value, $fail) use ($id) {
                    if ($this->service->repository->getModel()->where($attribute, $value)->where('id', '<>', $id)->exists()) {
                        $fail(trans('unique', [':attribute' => $attribute], 'validation'));
                    }
                }
            ]
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

    // delete
    #[DeleteMapping('position')]
    public function delete(Request $request): Response
    {
        $this->service->deleteById($request->all());
        return $this->success();
    }

}
