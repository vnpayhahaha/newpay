<?php

namespace http\openapi\controller;

use app\constants\Tenant;
use app\controller\BasicController;
use app\exception\OpenApiException;
use app\exception\UnprocessableEntityException;
use app\lib\enum\ResultCode;
use app\router\Annotations\PostMapping;
use app\router\Annotations\RestController;
use app\service\CollectionOrderService;
use app\service\TenantApiInterfaceService;
use app\service\TenantService;
use DI\Attribute\Inject;
use support\Request;
use support\Response;
use Webman\RateLimiter\Annotation\RateLimiter;
use Webman\RateLimiter\Limiter;

#[RestController("/v1/api/collection")]
class CollectionOrderController extends BasicController
{
    #[Inject]
    protected CollectionOrderService    $service;
    #[Inject]
    protected TenantService             $tenantService;
    #[Inject]
    protected TenantApiInterfaceService $tenantApiInterfaceService;

    #[PostMapping('/create_order')]
    #[RateLimiter(limit: 100, ttl: 60, key: RateLimiter::UID)]
    public function create_order(Request $request): Response
    {
        $params = $request->all();
        // 判断短时间内重复请求10s
        if(isset($params['tenant_order_no']) && filled($params['tenant_order_no'])){
            Limiter::check('collection_order_create_'.$params['tenant_order_no'], 1,10, trans('repeatedly', [':attribute' => 'tenant_order_no'], 'validation'));
        }
        $rate_limit = $this->tenantApiInterfaceService->getRateLimitByApiName('collection_order_create');
        Limiter::check('collection_order_create', $rate_limit, 1);
        // 参数验证
        $validator = validate($request->all(), [
            'tenant_id'       => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) use ($request) {
                    $findTenant = $this->tenantService->repository->getQuery()->select(['tenant_id', 'is_enabled', 'is_receipt'])->where('tenant_id', $value)->first();
                    if (!$findTenant) {
                        return $fail(trans('exists', [':attribute' => $attribute], 'validation'));
                    }
                    if ($findTenant->is_enabled === false || $findTenant->is_receipt === false) {
                        return $fail(trans('discontinued', [':attribute' => $attribute], 'validation'));
                    }
                }
            ],
            'app_key'         => 'required|string|max:16',
            'tenant_order_no' => [
                'required',
                'string',
                'max:64',
                function ($attribute, $value, $fail) use ($request) {
                    if ($this->service->repository->getQuery()->where('tenant_order_no', $value)->exists()) {
                        $fail(trans('unique', [':attribute' => $attribute], 'validation'));
                    }
                }
            ],
            'amount'          => 'required|numeric|min:0.01',
            'notify_url'      => 'string|max:255',
            'return_url'      => 'string|max:255',
            'notify_remark'   => 'string|max:255',
        ]);
        if ($validator->fails()) {
            throw new OpenApiException(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $successData = $this->service->createOrder($validatedData, $validatedData['app_key']);
        return $this->success([$successData]);
    }
}
