

> admin/passport/login
```json
{
  "username": "admin",
  "password": "123456",
  "code": "1234"
}
```
```json
{
    "code": 200,
    "message": "成功",
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NDkxMDI1OTcsIm5iZiI6MTc0OTEwMjU5NywiZXhwIjoxNzQ5MTA2MTk3LCJqdGkiOiIxIn0.cnE9tCAVev1NCgWBVVh8jX3Y1LNtAL9cWRU6Dv40s9c",
        "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NDkxMDI1OTcsIm5iZiI6MTc0OTEwMjU5NywiZXhwIjoxNzQ5MTA5Nzk3LCJqdGkiOiIxIiwic3ViIjoicmVmcmVzaCJ9.lVXkuhsosSITO19UobUk7CcqUWe1mbagDrxOke1lJlU",
        "expire_at": 3600
    }
}
```

---
> admin/passport/getInfo
```json
{
    "code": 200,
    "message": "成功",
    "data": {
        "username": "admin",
        "nickname": "创始人",
        "phone": "16858888988",
        "email": "admin@adminmine.com",
        "avatar": "",
        "signed": "广阔天地，大有所为",
        "backend_setting": {
            "app": {
                "layout": "columns",
                "asideDark": false,
                "colorMode": "autoMode",
                "useLocale": "zh_CN",
                "whiteRoute": [
                    "login"
                ],
                "pageAnimate": "ma-slide-down",
                "primaryColor": "#2563EB",
                "watermarkText": "MineAdmin",
                "showBreadcrumb": true,
                "enableWatermark": false,
                "loadUserSetting": true
            },
            "tabbar": {
                "mode": "rectangle",
                "enable": true
            },
            "subAside": {
                "showIcon": true,
                "showTitle": true,
                "fixedAsideState": false,
                "showCollapseButton": true
            },
            "copyright": {
                "dates": "2025",
                "enable": false,
                "company": "MineAdmin Team",
                "website": "https:\/\/www.mineadmin.com",
                "putOnRecord": "豫ICP备00000000号-1"
            },
            "mainAside": {
                "showIcon": true,
                "showTitle": true,
                "enableOpenFirstRoute": false
            },
            "welcomePage": {
                "icon": "icon-park-outline:jewelry",
                "name": "welcome",
                "path": "\/welcome",
                "title": "欢迎页"
            }
        }
    }
}
```
---
> admin/permission/menus
```json
{
    "code": 200,
    "message": "成功",
    "data": [
        {
            "id": 1,
            "parent_id": 0,
            "name": "permission",
            "meta": {
                "i18n": "baseMenu.permission.index",
                "icon": "ri:git-repository-private-line",
                "type": "M",
                "affix": false,
                "cache": true,
                "title": "权限管理",
                "hidden": false,
                "copyright": true,
                "componentPath": "modules\/",
                "componentSuffix": ".vue",
                "breadcrumbEnable": true
            },
            "path": "\/permission",
            "component": "",
            "redirect": "",
            "status": 1,
            "sort": 0,
            "created_by": 0,
            "updated_by": 0,
            "created_at": "2025-06-05 05:30:30",
            "updated_at": "2025-06-05 05:30:30",
            "remark": "",
            "children": [
                {
                    "id": 2,
                    "parent_id": 1,
                    "name": "permission:user",
                    "meta": {
                        "i18n": "baseMenu.permission.user",
                        "icon": "material-symbols:manage-accounts-outline",
                        "type": "M",
                        "affix": false,
                        "cache": true,
                        "title": "用户管理",
                        "hidden": false,
                        "copyright": true,
                        "componentPath": "modules\/",
                        "componentSuffix": ".vue",
                        "breadcrumbEnable": true
                    },
                    "path": "\/permission\/user",
                    "component": "base\/views\/permission\/user\/index",
                    "redirect": "",
                    "status": 1,
                    "sort": 0,
                    "created_by": 0,
                    "updated_by": 0,
                    "created_at": "2025-06-05 05:30:31",
                    "updated_at": "2025-06-05 05:30:31",
                    "remark": "",
                    "children": [
                        {
                            "id": 3,
                            "parent_id": 2,
                            "name": "permission:user:index",
                            "meta": {
                                "i18n": "baseMenu.permission.userList",
                                "type": "B",
                                "title": "用户列表"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:31",
                            "updated_at": "2025-06-05 05:30:31",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 4,
                            "parent_id": 2,
                            "name": "permission:user:save",
                            "meta": {
                                "i18n": "baseMenu.permission.userSave",
                                "type": "B",
                                "title": "用户保存"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:31",
                            "updated_at": "2025-06-05 05:30:31",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 5,
                            "parent_id": 2,
                            "name": "permission:user:update",
                            "meta": {
                                "i18n": "baseMenu.permission.userUpdate",
                                "type": "B",
                                "title": "用户更新"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:31",
                            "updated_at": "2025-06-05 05:30:31",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 6,
                            "parent_id": 2,
                            "name": "permission:user:delete",
                            "meta": {
                                "i18n": "baseMenu.permission.userDelete",
                                "type": "B",
                                "title": "用户删除"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:31",
                            "updated_at": "2025-06-05 05:30:31",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 7,
                            "parent_id": 2,
                            "name": "permission:user:password",
                            "meta": {
                                "i18n": "baseMenu.permission.userPassword",
                                "type": "B",
                                "title": "用户初始化密码"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:31",
                            "updated_at": "2025-06-05 05:30:31",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 8,
                            "parent_id": 2,
                            "name": "permission:user:getRole",
                            "meta": {
                                "i18n": "baseMenu.permission.getUserRole",
                                "type": "B",
                                "title": "获取用户角色"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:32",
                            "updated_at": "2025-06-05 05:30:37",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 9,
                            "parent_id": 2,
                            "name": "permission:user:setRole",
                            "meta": {
                                "i18n": "baseMenu.permission.setUserRole",
                                "type": "B",
                                "title": "用户角色赋予"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:32",
                            "updated_at": "2025-06-05 05:30:37",
                            "remark": "",
                            "children": []
                        }
                    ]
                },
                {
                    "id": 10,
                    "parent_id": 1,
                    "name": "permission:menu",
                    "meta": {
                        "i18n": "baseMenu.permission.menu",
                        "icon": "ph:list-bold",
                        "type": "M",
                        "affix": false,
                        "cache": true,
                        "title": "菜单管理",
                        "hidden": false,
                        "copyright": true,
                        "componentPath": "modules\/",
                        "componentSuffix": ".vue",
                        "breadcrumbEnable": true
                    },
                    "path": "\/permission\/menu",
                    "component": "base\/views\/permission\/menu\/index",
                    "redirect": "",
                    "status": 1,
                    "sort": 0,
                    "created_by": 0,
                    "updated_by": 0,
                    "created_at": "2025-06-05 05:30:32",
                    "updated_at": "2025-06-05 05:30:32",
                    "remark": "",
                    "children": [
                        {
                            "id": 11,
                            "parent_id": 10,
                            "name": "permission:menu:index",
                            "meta": {
                                "i18n": "baseMenu.permission.menuList",
                                "type": "B",
                                "title": "菜单列表"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:32",
                            "updated_at": "2025-06-05 05:30:32",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 12,
                            "parent_id": 10,
                            "name": "permission:menu:create",
                            "meta": {
                                "i18n": "baseMenu.permission.menuSave",
                                "type": "B",
                                "title": "菜单保存"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:32",
                            "updated_at": "2025-06-05 05:30:32",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 13,
                            "parent_id": 10,
                            "name": "permission:menu:save",
                            "meta": {
                                "i18n": "baseMenu.permission.menuUpdate",
                                "type": "B",
                                "title": "菜单更新"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:33",
                            "updated_at": "2025-06-05 05:30:33",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 14,
                            "parent_id": 10,
                            "name": "permission:menu:delete",
                            "meta": {
                                "i18n": "baseMenu.permission.menuDelete",
                                "type": "B",
                                "title": "菜单删除"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:33",
                            "updated_at": "2025-06-05 05:30:33",
                            "remark": "",
                            "children": []
                        }
                    ]
                },
                {
                    "id": 15,
                    "parent_id": 1,
                    "name": "permission:role",
                    "meta": {
                        "i18n": "baseMenu.permission.role",
                        "icon": "material-symbols:supervisor-account-outline-rounded",
                        "type": "M",
                        "affix": false,
                        "cache": true,
                        "title": "角色管理",
                        "hidden": false,
                        "copyright": true,
                        "componentPath": "modules\/",
                        "componentSuffix": ".vue",
                        "breadcrumbEnable": true
                    },
                    "path": "\/permission\/role",
                    "component": "base\/views\/permission\/role\/index",
                    "redirect": "",
                    "status": 1,
                    "sort": 0,
                    "created_by": 0,
                    "updated_by": 0,
                    "created_at": "2025-06-05 05:30:33",
                    "updated_at": "2025-06-05 05:30:33",
                    "remark": "",
                    "children": [
                        {
                            "id": 16,
                            "parent_id": 15,
                            "name": "permission:role:index",
                            "meta": {
                                "i18n": "baseMenu.permission.roleList",
                                "type": "B",
                                "title": "角色列表"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:33",
                            "updated_at": "2025-06-05 05:30:33",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 17,
                            "parent_id": 15,
                            "name": "permission:role:save",
                            "meta": {
                                "i18n": "baseMenu.permission.roleSave",
                                "type": "B",
                                "title": "角色保存"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:33",
                            "updated_at": "2025-06-05 05:30:33",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 18,
                            "parent_id": 15,
                            "name": "permission:role:update",
                            "meta": {
                                "i18n": "baseMenu.permission.roleUpdate",
                                "type": "B",
                                "title": "角色更新"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:33",
                            "updated_at": "2025-06-05 05:30:33",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 19,
                            "parent_id": 15,
                            "name": "permission:role:delete",
                            "meta": {
                                "i18n": "baseMenu.permission.roleDelete",
                                "type": "B",
                                "title": "角色删除"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:34",
                            "updated_at": "2025-06-05 05:30:34",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 20,
                            "parent_id": 15,
                            "name": "permission:role:getMenu",
                            "meta": {
                                "i18n": "baseMenu.permission.getRolePermission",
                                "type": "B",
                                "title": "获取角色权限"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:34",
                            "updated_at": "2025-06-05 05:30:36",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 21,
                            "parent_id": 15,
                            "name": "permission:role:setMenu",
                            "meta": {
                                "i18n": "baseMenu.permission.setRolePermission",
                                "type": "B",
                                "title": "赋予角色权限"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:34",
                            "updated_at": "2025-06-05 05:30:37",
                            "remark": "",
                            "children": []
                        }
                    ]
                },
                {
                    "id": 34,
                    "parent_id": 1,
                    "name": "permission:department",
                    "meta": {
                        "i18n": "baseMenu.permission.department",
                        "icon": "mingcute:department-line",
                        "type": "M",
                        "affix": false,
                        "cache": true,
                        "title": "部门管理",
                        "hidden": false,
                        "copyright": true,
                        "componentPath": "modules\/",
                        "componentSuffix": ".vue",
                        "breadcrumbEnable": true
                    },
                    "path": "\/permission\/departments",
                    "component": "base\/views\/permission\/department\/index",
                    "redirect": "",
                    "status": 1,
                    "sort": 0,
                    "created_by": 0,
                    "updated_by": 0,
                    "created_at": "2025-06-05 05:30:37",
                    "updated_at": "2025-06-05 05:30:37",
                    "remark": "",
                    "children": [
                        {
                            "id": 35,
                            "parent_id": 34,
                            "name": "permission:department:index",
                            "meta": {
                                "i18n": "baseMenu.permission.departmentList",
                                "type": "B",
                                "affix": false,
                                "cache": true,
                                "title": "部门列表",
                                "hidden": true
                            },
                            "path": "\/permission\/departments",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:37",
                            "updated_at": "2025-06-05 05:30:37",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 36,
                            "parent_id": 34,
                            "name": "permission:department:save",
                            "meta": {
                                "i18n": "baseMenu.permission.departmentCreate",
                                "type": "B",
                                "affix": false,
                                "cache": true,
                                "title": "部门新增",
                                "hidden": true
                            },
                            "path": "\/permission\/departments",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:38",
                            "updated_at": "2025-06-05 05:30:38",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 37,
                            "parent_id": 34,
                            "name": "permission:department:update",
                            "meta": {
                                "i18n": "baseMenu.permission.departmentSave",
                                "type": "B",
                                "affix": false,
                                "cache": true,
                                "title": "部门编辑",
                                "hidden": true
                            },
                            "path": "\/permission\/departments",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:38",
                            "updated_at": "2025-06-05 05:30:38",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 38,
                            "parent_id": 34,
                            "name": "permission:department:delete",
                            "meta": {
                                "i18n": "baseMenu.permission.departmentDelete",
                                "type": "B",
                                "affix": false,
                                "cache": true,
                                "title": "部门删除",
                                "hidden": true
                            },
                            "path": "\/permission\/departments",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:38",
                            "updated_at": "2025-06-05 05:30:38",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 39,
                            "parent_id": 34,
                            "name": "permission:position:index",
                            "meta": {
                                "i18n": "baseMenu.permission.positionList",
                                "type": "B",
                                "affix": false,
                                "cache": true,
                                "title": "岗位列表",
                                "hidden": true
                            },
                            "path": "\/permission\/departments",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:38",
                            "updated_at": "2025-06-05 05:30:38",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 40,
                            "parent_id": 34,
                            "name": "permission:position:save",
                            "meta": {
                                "i18n": "baseMenu.permission.positionCreate",
                                "type": "B",
                                "affix": false,
                                "cache": true,
                                "title": "岗位新增",
                                "hidden": true
                            },
                            "path": "\/permission\/departments",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:38",
                            "updated_at": "2025-06-05 05:30:38",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 41,
                            "parent_id": 34,
                            "name": "permission:position:update",
                            "meta": {
                                "i18n": "baseMenu.permission.positionSave",
                                "type": "B",
                                "affix": false,
                                "cache": true,
                                "title": "岗位编辑",
                                "hidden": true
                            },
                            "path": "\/permission\/departments",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:38",
                            "updated_at": "2025-06-05 05:30:38",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 42,
                            "parent_id": 34,
                            "name": "permission:position:delete",
                            "meta": {
                                "i18n": "baseMenu.permission.positionDelete",
                                "type": "B",
                                "affix": false,
                                "cache": true,
                                "title": "岗位删除",
                                "hidden": true
                            },
                            "path": "\/permission\/departments",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:39",
                            "updated_at": "2025-06-05 05:30:39",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 43,
                            "parent_id": 34,
                            "name": "permission:position:data_permission",
                            "meta": {
                                "i18n": "baseMenu.permission.positionDataScope",
                                "type": "B",
                                "affix": false,
                                "cache": true,
                                "title": "设置岗位数据权限",
                                "hidden": true
                            },
                            "path": "\/permission\/departments",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:39",
                            "updated_at": "2025-06-05 05:30:39",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 44,
                            "parent_id": 34,
                            "name": "permission:leader:index",
                            "meta": {
                                "i18n": "baseMenu.permission.leaderList",
                                "type": "B",
                                "affix": false,
                                "cache": true,
                                "title": "部门领导列表",
                                "hidden": true
                            },
                            "path": "\/permission\/departments",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:39",
                            "updated_at": "2025-06-05 05:30:39",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 45,
                            "parent_id": 34,
                            "name": "permission:leader:save",
                            "meta": {
                                "i18n": "baseMenu.permission.leaderCreate",
                                "type": "B",
                                "affix": false,
                                "cache": true,
                                "title": "新增部门领导",
                                "hidden": true
                            },
                            "path": "\/permission\/departments",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:39",
                            "updated_at": "2025-06-05 05:30:39",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 46,
                            "parent_id": 34,
                            "name": "permission:leader:delete",
                            "meta": {
                                "i18n": "baseMenu.permission.leaderDelete",
                                "type": "B",
                                "affix": false,
                                "cache": true,
                                "title": "部门领导移除",
                                "hidden": true
                            },
                            "path": "\/permission\/departments",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:39",
                            "updated_at": "2025-06-05 05:30:39",
                            "remark": "",
                            "children": []
                        }
                    ]
                }
            ]
        },
        {
            "id": 22,
            "parent_id": 0,
            "name": "log",
            "meta": {
                "i18n": "baseMenu.log.index",
                "icon": "ph:instagram-logo",
                "type": "M",
                "affix": false,
                "cache": true,
                "title": "日志管理",
                "hidden": false,
                "copyright": true,
                "componentPath": "modules\/",
                "componentSuffix": ".vue",
                "breadcrumbEnable": true
            },
            "path": "\/log",
            "component": "",
            "redirect": "",
            "status": 1,
            "sort": 0,
            "created_by": 0,
            "updated_by": 0,
            "created_at": "2025-06-05 05:30:34",
            "updated_at": "2025-06-05 05:30:34",
            "remark": "",
            "children": [
                {
                    "id": 23,
                    "parent_id": 22,
                    "name": "log:userLogin",
                    "meta": {
                        "i18n": "baseMenu.log.userLoginLog",
                        "icon": "ph:user-list",
                        "type": "M",
                        "affix": false,
                        "cache": true,
                        "title": "用户登录日志管理",
                        "hidden": false,
                        "copyright": true,
                        "componentPath": "modules\/",
                        "componentSuffix": ".vue",
                        "breadcrumbEnable": true
                    },
                    "path": "\/log\/userLoginLog",
                    "component": "base\/views\/log\/userLogin",
                    "redirect": "",
                    "status": 1,
                    "sort": 0,
                    "created_by": 0,
                    "updated_by": 0,
                    "created_at": "2025-06-05 05:30:34",
                    "updated_at": "2025-06-05 05:30:34",
                    "remark": "",
                    "children": [
                        {
                            "id": 24,
                            "parent_id": 23,
                            "name": "log:userLogin:list",
                            "meta": {
                                "i18n": "baseMenu.log.userLoginLogList",
                                "type": "B",
                                "title": "用户登录日志列表"
                            },
                            "path": "\/log\/userLoginLog",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:35",
                            "updated_at": "2025-06-05 05:30:35",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 25,
                            "parent_id": 23,
                            "name": "log:userLogin:delete",
                            "meta": {
                                "i18n": "baseMenu.log.userLoginLogDelete",
                                "type": "B",
                                "title": "删除用户登录日志"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:35",
                            "updated_at": "2025-06-05 05:30:35",
                            "remark": "",
                            "children": []
                        }
                    ]
                },
                {
                    "id": 26,
                    "parent_id": 22,
                    "name": "log:userOperation",
                    "meta": {
                        "i18n": "baseMenu.log.operationLog",
                        "icon": "ph:list-magnifying-glass",
                        "type": "M",
                        "affix": false,
                        "cache": true,
                        "title": "操作日志管理",
                        "hidden": false,
                        "copyright": true,
                        "componentPath": "modules\/",
                        "componentSuffix": ".vue",
                        "breadcrumbEnable": true
                    },
                    "path": "\/log\/operationLog",
                    "component": "base\/views\/log\/userOperation",
                    "redirect": "",
                    "status": 1,
                    "sort": 0,
                    "created_by": 0,
                    "updated_by": 0,
                    "created_at": "2025-06-05 05:30:35",
                    "updated_at": "2025-06-05 05:30:35",
                    "remark": "",
                    "children": [
                        {
                            "id": 27,
                            "parent_id": 26,
                            "name": "log:userOperation:list",
                            "meta": {
                                "i18n": "baseMenu.log.userOperationLog",
                                "type": "B",
                                "title": "用户操作日志列表"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:35",
                            "updated_at": "2025-06-05 05:30:35",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 28,
                            "parent_id": 26,
                            "name": "log:userOperation:delete",
                            "meta": {
                                "i18n": "baseMenu.log.userOperationLogDelete",
                                "type": "B",
                                "title": "删除用户操作日志"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:35",
                            "updated_at": "2025-06-05 05:30:35",
                            "remark": "",
                            "children": []
                        }
                    ]
                }
            ]
        },
        {
            "id": 29,
            "parent_id": 0,
            "name": "dataCenter",
            "meta": {
                "i18n": "baseMenu.dataCenter.index",
                "icon": "ri:database-line",
                "type": "M",
                "affix": false,
                "cache": true,
                "title": "数据中心",
                "hidden": false,
                "copyright": true,
                "componentPath": "modules\/",
                "componentSuffix": ".vue",
                "breadcrumbEnable": true
            },
            "path": "\/dataCenter",
            "component": "",
            "redirect": "",
            "status": 1,
            "sort": 0,
            "created_by": 0,
            "updated_by": 0,
            "created_at": "2025-06-05 05:30:35",
            "updated_at": "2025-06-05 05:30:35",
            "remark": "",
            "children": [
                {
                    "id": 30,
                    "parent_id": 29,
                    "name": "dataCenter:attachment",
                    "meta": {
                        "i18n": "baseMenu.dataCenter.attachment",
                        "icon": "ri:attachment-line",
                        "type": "M",
                        "affix": false,
                        "cache": true,
                        "title": "附件管理",
                        "hidden": false,
                        "copyright": true,
                        "componentPath": "modules\/",
                        "componentSuffix": ".vue",
                        "breadcrumbEnable": true
                    },
                    "path": "\/dataCenter\/attachment",
                    "component": "base\/views\/dataCenter\/attachment\/index",
                    "redirect": "",
                    "status": 1,
                    "sort": 0,
                    "created_by": 0,
                    "updated_by": 0,
                    "created_at": "2025-06-05 05:30:36",
                    "updated_at": "2025-06-05 05:30:36",
                    "remark": "",
                    "children": [
                        {
                            "id": 31,
                            "parent_id": 30,
                            "name": "dataCenter:attachment:list",
                            "meta": {
                                "i18n": "baseMenu.dataCenter.attachmentList",
                                "type": "B",
                                "title": "附件列表"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:36",
                            "updated_at": "2025-06-05 05:30:36",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 32,
                            "parent_id": 30,
                            "name": "dataCenter:attachment:upload",
                            "meta": {
                                "i18n": "baseMenu.dataCenter.attachmentUpload",
                                "type": "B",
                                "title": "上传附件"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:36",
                            "updated_at": "2025-06-05 05:30:36",
                            "remark": "",
                            "children": []
                        },
                        {
                            "id": 33,
                            "parent_id": 30,
                            "name": "dataCenter:attachment:delete",
                            "meta": {
                                "i18n": "baseMenu.dataCenter.attachmentDelete",
                                "type": "B",
                                "title": "删除附件"
                            },
                            "path": "",
                            "component": "",
                            "redirect": "",
                            "status": 1,
                            "sort": 0,
                            "created_by": 0,
                            "updated_by": 0,
                            "created_at": "2025-06-05 05:30:36",
                            "updated_at": "2025-06-05 05:30:36",
                            "remark": "",
                            "children": []
                        }
                    ]
                }
            ]
        }
    ]
}
```
---
> admin/permission/roles
```json
{
    "code": 200,
    "message": "成功",
    "data": [
        {
            "id": 1,
            "name": "超级管理员",
            "code": "SuperAdmin",
            "status": 1,
            "sort": 0,
            "created_by": 0,
            "updated_by": 0,
            "created_at": "2025-06-05 05:30:40",
            "updated_at": "2025-06-05 05:30:40",
            "remark": ""
        }
    ]
}
```
---
> /admin/attachment/list?page_size=30&page=1
```json
{
    "code": 200,
    "message": "成功",
    "data": {
        "list": [
            {
                "id": 2,
                "storage_mode": 0,
                "origin_name": "bg1.png",
                "object_name": "d8850095-84ec-4a7e-9196-6d3d63fab5ac.png",
                "hash": "5fd6828a9b2ebd70c162ec2707791dd2",
                "mime_type": "image\/png",
                "storage_path": "2025-06-05",
                "suffix": "png",
                "size_byte": 4721405,
                "size_info": "4721405",
                "url": "http:\/\/127.0.0.1:9501\/uploads\/2025-06-05\/d8850095-84ec-4a7e-9196-6d3d63fab5ac.png",
                "created_by": 1,
                "updated_by": 0,
                "created_at": "2025-06-05 05:44:00",
                "updated_at": "2025-06-05 05:44:00",
                "remark": ""
            }
        ],
        "total": 1
    }
}
```
---
> admin/user/list?page=1&page_size=10
```json
{
    "code": 200,
    "message": "成功",
    "data": {
        "list": [
            {
                "id": 1,
                "username": "admin",
                "user_type": 100,
                "nickname": "创始人",
                "phone": "16858888988",
                "email": "admin@adminmine.com",
                "avatar": "",
                "signed": "广阔天地，大有所为",
                "status": 1,
                "login_ip": "127.0.0.1",
                "login_time": "2025-06-05 12:30:40",
                "backend_setting": {
                    "app": {
                        "layout": "columns",
                        "asideDark": false,
                        "colorMode": "autoMode",
                        "useLocale": "zh_CN",
                        "whiteRoute": [
                            "login"
                        ],
                        "pageAnimate": "ma-slide-down",
                        "primaryColor": "#2563EB",
                        "watermarkText": "MineAdmin",
                        "showBreadcrumb": true,
                        "enableWatermark": false,
                        "loadUserSetting": true
                    },
                    "tabbar": {
                        "mode": "rectangle",
                        "enable": true
                    },
                    "subAside": {
                        "showIcon": true,
                        "showTitle": true,
                        "fixedAsideState": false,
                        "showCollapseButton": true
                    },
                    "copyright": {
                        "dates": "2025",
                        "enable": false,
                        "company": "MineAdmin Team",
                        "website": "https:\/\/www.mineadmin.com",
                        "putOnRecord": "豫ICP备00000000号-1"
                    },
                    "mainAside": {
                        "showIcon": true,
                        "showTitle": true,
                        "enableOpenFirstRoute": false
                    },
                    "welcomePage": {
                        "icon": "icon-park-outline:jewelry",
                        "name": "welcome",
                        "path": "\/welcome",
                        "title": "欢迎页"
                    }
                },
                "created_by": 0,
                "updated_by": 0,
                "created_at": "2025-06-05 05:30:40",
                "updated_at": "2025-06-05 05:48:12",
                "remark": "",
                "policy": null,
                "department": [],
                "dept_leader": [],
                "position": []
            }
        ],
        "total": 1
    }
}
```
```json
{
    "code": 200,
    "message": "成功",
    "data": {
        "created_by": 1,
        "origin_name": "ChMkK2VuiYOIAt4fAADe7KV_wZgAAX6mQLS-ysAAN8E319.jpg",
        "storage_mode": 0,
        "object_name": "a2f329ce-3143-4c0c-bcef-0f07343b36ef.jpg",
        "mime_type": "image\/jpeg",
        "storage_path": "2025-06-17",
        "hash": "473a077cb76edab1d3525751ec25d236",
        "suffix": "jpg",
        "size_byte": 37963,
        "size_info": 37963,
        "url": "http:\/\/127.0.0.1:9501\/uploads\/2025-06-17\/a2f329ce-3143-4c0c-bcef-0f07343b36ef.jpg",
        "updated_at": "2025-06-17 00:54:32",
        "created_at": "2025-06-17 00:54:32",
        "id": 5
    }
}
```
