<?php

namespace http\tenant\controller;

use app\controller\BasicController;
use app\exception\UnprocessableEntityException;
use app\lib\enum\ResultCode;
use app\router\Annotations\GetMapping;
use app\router\Annotations\PostMapping;
use app\router\Annotations\RestController;
use app\service\TenantUserService;
use DI\Attribute\Inject;
use Illuminate\Support\Arr;
use support\Request;
use support\Response;

#[RestController("/tenant/permission")]
class PermissionController extends BasicController
{
    #[Inject]
    protected TenantUserService $userService;

    #[GetMapping('/menus')]
    public function menus(Request $request): Response
    {
        $jsonData = <<< JSON
[
{
            "id": 168,
            "parent_id": 0,
            "name": "CollectionOrder",
            "meta": {
                "i18n": "collection_order.index",
                "icon": "mdi:order-bool-ascending",
                "type": "M",
                "affix": false,
                "cache": true,
                "title": "\u65b0\u589e\u9876\u7ea7\u83dc\u5355",
                "hidden": false,
                "copyright": true,
                "activeName": "",
                "componentPath": "modules\/",
                "componentSuffix": ".vue",
                "breadcrumbEnable": true
            },
            "path": "\/CollectionOrder",
            "component": "",
            "redirect": "",
            "status": 1,
            "sort": 0,
            "created_by": 1,
            "updated_by": 0,
            "created_at": "2025-07-14 03:59:27",
            "updated_at": "2025-07-14 03:59:27",
            "remark": "",
            "children": [
                {
                    "id": 170,
                    "parent_id": 168,
                    "name": "CollectionOrderAll",
                    "meta": {
                        "i18n": "collection_order.all",
                        "icon": "ri:menu-search-line",
                        "type": "M",
                        "affix": false,
                        "cache": true,
                        "title": "\u6536\u6b3e\u8ba2\u5355",
                        "hidden": false,
                        "copyright": true,
                        "componentPath": "modules\/",
                        "componentSuffix": ".vue",
                        "breadcrumbEnable": true
                    },
                    "path": "\/transaction\/CollectionOrder",
                    "component": "transaction\/views\/CollectionOrder\/Index",
                    "redirect": "",
                    "status": 1,
                    "sort": 0,
                    "created_by": 0,
                    "updated_by": 1,
                    "created_at": "2025-07-12 12:56:47",
                    "updated_at": "2025-07-14 04:06:14",
                    "remark": "",
                    "children": [
                    ]
                }
            ]
        },
        {
            "id": 175,
            "parent_id": 0,
            "name": "DisbursementOrder",
            "meta": {
                "i18n": "disbursement_order.index",
                "icon": "mdi:order-bool-descending",
                "type": "M",
                "affix": false,
                "cache": true,
                "title": "\u65b0\u589e\u9876\u7ea7\u83dc\u5355",
                "hidden": false,
                "copyright": true,
                "activeName": "",
                "componentPath": "modules\/",
                "componentSuffix": ".vue",
                "breadcrumbEnable": true
            },
            "path": "\/DisbursementOrder",
            "component": "",
            "redirect": "",
            "status": 1,
            "sort": 0,
            "created_by": 1,
            "updated_by": 1,
            "created_at": "2025-07-14 08:46:55",
            "updated_at": "2025-07-14 08:55:31",
            "remark": "",
            "children": [
                {
                    "id": 178,
                    "parent_id": 175,
                    "name": "DisbursementOrderAll",
                    "meta": {
                        "i18n": "disbursement_order.all",
                        "icon": "ri:menu-search-line",
                        "type": "M",
                        "affix": false,
                        "cache": true,
                        "title": "\u4ed8\u6b3e\u8ba2\u5355",
                        "hidden": false,
                        "copyright": true,
                        "componentPath": "modules\/",
                        "componentSuffix": ".vue",
                        "breadcrumbEnable": true
                    },
                    "path": "\/transaction\/DisbursementOrder",
                    "component": "transaction\/views\/DisbursementOrder\/Index",
                    "redirect": "",
                    "status": 1,
                    "sort": 0,
                    "created_by": 0,
                    "updated_by": 1,
                    "created_at": "2025-07-12 22:34:46",
                    "updated_at": "2025-07-14 08:53:29",
                    "remark": "",
                    "children": [
                    ]
                }
            ]
        }]
JSON;

        return $this->success(json_decode($jsonData,true));
    }

    #[GetMapping('/roles')]
    public function roles(Request $request): Response
    {
        //     {
        //      "id": 1,
        //      "name": "\u8d85\u7ea7\u7ba1\u7406\u5458",
        //      "code": "SuperAdmin",
        //      "status": 1,
        //      "sort": 0,
        //      "created_by": 0,
        //      "updated_by": 0,
        //      "created_at": "2025-06-05 05:30:40",
        //      "updated_at": "2025-06-05 05:30:40",
        //      "remark": ""
        //    }
        return $this->success([
          [
              'id'         => 1,
              'name'       => '超级管理员',
              'code'       => 'SuperAdmin',
              'status'     => 1,
              'sort'       => 0,
              'created_by' => 0,
              'updated_by' => 0,
              'created_at' => '2025-06-05 05:30:40',
              'updated_at' => '2025-06-05 05:30:40',
              'remark'     => '',
          ]
        ]);
    }

    #[PostMapping('/update')]
    public function update(Request $request): Response
    {
        $validator = validate($request->post(), [
            'new_password'              => 'sometimes|confirmed|string|min:8',
            'new_password_confirmation' => 'sometimes|string|min:8',
            'old_password'              => ['sometimes', 'string'],
            'avatar'                    => 'sometimes|string|max:255',
            'backend_setting'           => 'sometimes|array',
        ]);
        if ($validator->fails()) {
            throw new UnprocessableEntityException(ResultCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $validatedData = $validator->validate();
        $user = $request->user;
        if (Arr::exists($validatedData, 'new_password')) {
            if (!$user->verifyPassword(Arr::get($validatedData, 'old_password'))) {
                throw new UnprocessableEntityException(ResultCode::UNPROCESSABLE_ENTITY, trans('old_password_error', [], 'user'));
            }
            $validatedData['password'] = $validatedData['new_password'];
        }
        $this->userService->updateById($user->id, $validatedData);
        return $this->success();
    }
}
