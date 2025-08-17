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
    "title": "新增顶级菜单",
    "hidden": false,
    "copyright": true,
    "activeName": "",
    "componentPath": "modules/",
    "componentSuffix": ".vue",
    "breadcrumbEnable": true
  },
  "path": "/transaction/CollectionOrder",
  "component": "transaction/views/CollectionOrder/Index",
  "redirect": "",
  "status": 1,
  "sort": 0,
  "created_by": 1,
  "updated_by": 1,
  "created_at": "2025-07-14 03:59:27",
  "updated_at": "2025-07-24 07:54:39",
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
        "title": "收款订单",
        "hidden": false,
        "copyright": true,
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/transaction/CollectionOrder",
      "component": "transaction/views/CollectionOrder/Index",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 0,
      "updated_by": 1,
      "created_at": "2025-07-12 12:56:47",
      "updated_at": "2025-07-14 04:06:14",
      "remark": "",
      "children": [
        {
          "id": 171,
          "parent_id": 170,
          "name": "transaction:collection_order:list",
          "meta": {
            "i18n": "menu.collection_order.list",
            "type": "B",
            "title": "收款订单列表"
          },
          "path": "",
          "component": "",
          "redirect": "",
          "status": 1,
          "sort": 0,
          "created_by": 0,
          "updated_by": 0,
          "created_at": "2025-07-12 12:56:47",
          "updated_at": "2025-07-14 04:06:14",
          "remark": "",
          "children": []
        },
        {
          "id": 172,
          "parent_id": 170,
          "name": "transaction:collection_order:create",
          "meta": {
            "i18n": "menu.collection_order.create",
            "type": "B",
            "title": "收款订单新增"
          },
          "path": "",
          "component": "",
          "redirect": "",
          "status": 1,
          "sort": 0,
          "created_by": 0,
          "updated_by": 0,
          "created_at": "2025-07-12 12:56:47",
          "updated_at": "2025-07-14 04:06:15",
          "remark": "",
          "children": []
        },
        {
          "id": 173,
          "parent_id": 170,
          "name": "transaction:collection_order:update",
          "meta": {
            "i18n": "menu.collection_order.update",
            "type": "B",
            "title": "收款订单编辑"
          },
          "path": "",
          "component": "",
          "redirect": "",
          "status": 1,
          "sort": 0,
          "created_by": 0,
          "updated_by": 0,
          "created_at": "2025-07-12 12:56:47",
          "updated_at": "2025-07-14 04:06:15",
          "remark": "",
          "children": []
        },
        {
          "id": 174,
          "parent_id": 170,
          "name": "transaction:collection_order:delete",
          "meta": {
            "i18n": "menu.collection_order.delete",
            "type": "B",
            "title": "收款订单删除"
          },
          "path": "",
          "component": "",
          "redirect": "",
          "status": 1,
          "sort": 0,
          "created_by": 0,
          "updated_by": 0,
          "created_at": "2025-07-12 12:56:47",
          "updated_at": "2025-07-14 04:06:15",
          "remark": "",
          "children": []
        }
      ]
    },
    {
      "id": 193,
      "parent_id": 168,
      "name": "CollectionOrderProcessing",
      "meta": {
        "i18n": "enums.CollectionOrder.status.processing",
        "icon": "ep:alarm-clock",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/CollectionOrder/processing",
      "component": "transaction/views/CollectionOrder/processing",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-04 11:25:26",
      "updated_at": "2025-08-04 11:33:42",
      "remark": "",
      "children": []
    },
    {
      "id": 194,
      "parent_id": 168,
      "name": "CollectionOrderSuccess",
      "meta": {
        "i18n": "enums.CollectionOrder.status.success",
        "icon": "ep:circle-check",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/CollectionOrder/success",
      "component": "transaction/views/CollectionOrder/success",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-04 11:32:34",
      "updated_at": "2025-08-04 11:39:56",
      "remark": "",
      "children": []
    },
    {
      "id": 195,
      "parent_id": 168,
      "name": "CollectionOrderSuspend",
      "meta": {
        "i18n": "enums.CollectionOrder.status.suspend",
        "icon": "ep:link",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/CollectionOrder/suspend",
      "component": "transaction/views/CollectionOrder/suspend",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-04 11:36:14",
      "updated_at": "2025-08-04 11:41:49",
      "remark": "",
      "children": []
    },
    {
      "id": 196,
      "parent_id": 168,
      "name": "CollectionOrderFail",
      "meta": {
        "i18n": "enums.CollectionOrder.status.fail",
        "icon": "mdi:cancel",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/CollectionOrder/fail",
      "component": "transaction/views/CollectionOrder/fail",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-04 11:39:26",
      "updated_at": "2025-08-04 11:43:36",
      "remark": "",
      "children": []
    },
    {
      "id": 197,
      "parent_id": 168,
      "name": "CollectionOrderCancel",
      "meta": {
        "i18n": "enums.CollectionOrder.status.cancel",
        "icon": "ep:circle-close",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/CollectionOrder/cancel",
      "component": "transaction/views/CollectionOrder/cancel",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-04 11:43:16",
      "updated_at": "2025-08-04 11:43:47",
      "remark": "",
      "children": []
    },
    {
      "id": 198,
      "parent_id": 168,
      "name": "CollectionOrderInvalid",
      "meta": {
        "i18n": "enums.CollectionOrder.status.invalid",
        "icon": "mdi:timer-cancel-outline",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/CollectionOrder/invalid",
      "component": "transaction/views/CollectionOrder/invalid",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-04 11:44:45",
      "updated_at": "2025-08-04 11:44:58",
      "remark": "",
      "children": []
    },
    {
      "id": 199,
      "parent_id": 168,
      "name": "CollectionOrderRefund",
      "meta": {
        "i18n": "enums.CollectionOrder.status.refund",
        "icon": "mdi:credit-card-refund-outline",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/CollectionOrder/refund",
      "component": "transaction/views/CollectionOrder/refund",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-04 11:46:45",
      "updated_at": "2025-08-04 11:46:56",
      "remark": "",
      "children": []
    }
  ]
},{
  "id": 175,
  "parent_id": 0,
  "name": "DisbursementOrder",
  "meta": {
    "i18n": "disbursement_order.index",
    "icon": "mdi:order-bool-descending",
    "type": "M",
    "affix": false,
    "cache": true,
    "title": "新增顶级菜单",
    "hidden": false,
    "copyright": true,
    "activeName": "",
    "componentPath": "modules/",
    "componentSuffix": ".vue",
    "breadcrumbEnable": true
  },
  "path": "/transaction/DisbursementOrder",
  "component": "transaction/views/DisbursementOrder/Index",
  "redirect": "",
  "status": 1,
  "sort": 0,
  "created_by": 1,
  "updated_by": 1,
  "created_at": "2025-07-14 08:46:55",
  "updated_at": "2025-07-24 07:54:50",
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
        "title": "付款订单",
        "hidden": false,
        "copyright": true,
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/transaction/DisbursementOrder",
      "component": "transaction/views/DisbursementOrder/Index",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 0,
      "updated_by": 1,
      "created_at": "2025-07-12 22:34:46",
      "updated_at": "2025-07-14 08:53:29",
      "remark": "",
      "children": [
        {
          "id": 179,
          "parent_id": 178,
          "name": "transaction:disbursement_order:list",
          "meta": {
            "i18n": "menu.disbursement_order.list",
            "type": "B",
            "title": "付款订单列表"
          },
          "path": "",
          "component": "",
          "redirect": "",
          "status": 1,
          "sort": 0,
          "created_by": 0,
          "updated_by": 0,
          "created_at": "2025-07-12 22:34:46",
          "updated_at": "2025-07-14 08:53:29",
          "remark": "",
          "children": []
        },
        {
          "id": 180,
          "parent_id": 178,
          "name": "transaction:disbursement_order:create",
          "meta": {
            "i18n": "menu.disbursement_order.create",
            "type": "B",
            "title": "付款订单新增"
          },
          "path": "",
          "component": "",
          "redirect": "",
          "status": 1,
          "sort": 0,
          "created_by": 0,
          "updated_by": 0,
          "created_at": "2025-07-12 22:34:46",
          "updated_at": "2025-07-14 08:53:29",
          "remark": "",
          "children": []
        },
        {
          "id": 181,
          "parent_id": 178,
          "name": "transaction:disbursement_order:update",
          "meta": {
            "i18n": "menu.disbursement_order.update",
            "type": "B",
            "title": "付款订单编辑"
          },
          "path": "",
          "component": "",
          "redirect": "",
          "status": 1,
          "sort": 0,
          "created_by": 0,
          "updated_by": 0,
          "created_at": "2025-07-12 22:34:46",
          "updated_at": "2025-07-14 08:53:29",
          "remark": "",
          "children": []
        },
        {
          "id": 182,
          "parent_id": 178,
          "name": "transaction:disbursement_order:delete",
          "meta": {
            "i18n": "menu.disbursement_order.delete",
            "type": "B",
            "title": "付款订单删除"
          },
          "path": "",
          "component": "",
          "redirect": "",
          "status": 1,
          "sort": 0,
          "created_by": 0,
          "updated_by": 0,
          "created_at": "2025-07-12 22:34:46",
          "updated_at": "2025-07-14 08:53:30",
          "remark": "",
          "children": []
        }
      ]
    },
    {
      "id": 200,
      "parent_id": 175,
      "name": "DisbursementOrderCreate",
      "meta": {
        "i18n": "enums.disbursement_order.status.create",
        "icon": "ri:apps-2-add-line",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/DisbursementOrder/create",
      "component": "transaction/views/DisbursementOrder/create",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-10 13:09:52",
      "updated_at": "2025-08-10 13:16:36",
      "remark": "",
      "children": []
    },
    {
      "id": 201,
      "parent_id": 175,
      "name": "DisbursementOrderWaitPay",
      "meta": {
        "i18n": "enums.disbursement_order.status.wait_pay",
        "icon": "ri:paypal-line",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/DisbursementOrder/waitPay",
      "component": "transaction/views/DisbursementOrder/waitPay",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-10 13:22:11",
      "updated_at": "2025-08-10 13:22:41",
      "remark": "",
      "children": []
    },
    {
      "id": 202,
      "parent_id": 175,
      "name": "DisbursementOrderWaitFill",
      "meta": {
        "i18n": "enums.disbursement_order.status.wait_fill",
        "icon": "mdi:chat-processing-outline",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/DisbursementOrder/waitFill",
      "component": "transaction/views/DisbursementOrder/waitFill",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-10 13:31:20",
      "updated_at": "2025-08-10 13:47:55",
      "remark": "",
      "children": []
    },
    {
      "id": 203,
      "parent_id": 175,
      "name": "DisbursementOrderSuccess",
      "meta": {
        "i18n": "enums.disbursement_order.status.success",
        "icon": "ri:wechat-pay-line",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/DisbursementOrder/success",
      "component": "transaction/views/DisbursementOrder/success",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-10 13:49:27",
      "updated_at": "2025-08-10 13:49:45",
      "remark": "",
      "children": []
    },
    {
      "id": 204,
      "parent_id": 175,
      "name": "DisbursementOrderSuspend",
      "meta": {
        "i18n": "enums.disbursement_order.status.suspend",
        "icon": "ant-design:warning-outlined",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/DisbursementOrder/suspend",
      "component": "transaction/views/DisbursementOrder/suspend",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-10 13:50:31",
      "updated_at": "2025-08-10 14:00:52",
      "remark": "",
      "children": []
    },
    {
      "id": 205,
      "parent_id": 175,
      "name": "DisbursementOrderFail",
      "meta": {
        "i18n": "enums.disbursement_order.status.fail",
        "icon": "mdi:cancel",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/DisbursementOrder/fail",
      "component": "transaction/views/DisbursementOrder/fail",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-10 13:50:31",
      "updated_at": "2025-08-10 13:51:45",
      "remark": "",
      "children": []
    },
    {
      "id": 206,
      "parent_id": 175,
      "name": "DisbursementOrderCancel",
      "meta": {
        "i18n": "enums.disbursement_order.status.cancel",
        "icon": "ep:circle-close",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/DisbursementOrder/cancel",
      "component": "transaction/views/DisbursementOrder/cancel",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-10 13:52:34",
      "updated_at": "2025-08-10 13:53:05",
      "remark": "",
      "children": []
    },
    {
      "id": 207,
      "parent_id": 175,
      "name": "DisbursementOrderInvalid",
      "meta": {
        "i18n": "enums.disbursement_order.status.invalid",
        "icon": "mdi:timer-cancel-outline",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/DisbursementOrder/invalid",
      "component": "transaction/views/DisbursementOrder/invalid",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-10 13:53:45",
      "updated_at": "2025-08-10 13:54:01",
      "remark": "",
      "children": []
    },
    {
      "id": 208,
      "parent_id": 175,
      "name": "DisbursementOrderRefund",
      "meta": {
        "i18n": "enums.disbursement_order.status.refund",
        "icon": "mdi:credit-card-refund-outline",
        "type": "M",
        "affix": false,
        "cache": true,
        "title": "新菜单",
        "hidden": false,
        "copyright": true,
        "activeName": "",
        "componentPath": "modules/",
        "componentSuffix": ".vue",
        "breadcrumbEnable": true
      },
      "path": "/DisbursementOrder/refund",
      "component": "transaction/views/DisbursementOrder/refund",
      "redirect": "",
      "status": 1,
      "sort": 0,
      "created_by": 1,
      "updated_by": 1,
      "created_at": "2025-08-10 14:03:48",
      "updated_at": "2025-08-10 14:04:14",
      "remark": "",
      "children": []
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
