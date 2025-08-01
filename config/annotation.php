<?php

return [
    // 注解扫描路径, 只扫描应用目录下已定义的文件夹，例如： app/admin/controller 及其下级目录
    'include_paths' => [
        'http/backend',
        'http/tenant',
        'http/openapi',
        'http/common',
    ],
    // requestMapping 允许的请求method
    'allow_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'HEAD', 'PATCH'],
];
