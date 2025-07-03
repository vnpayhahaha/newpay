<?php

return [
    'operation.log'         => [
        [\app\event\OperationEvent::class, 'process'],
    ],
    'app.tenant.created' => [
        [\app\event\TenantEvent::class, 'Created'],
    ],
    'backend.user.login'    => [
        [\http\backend\Service\PassportService::class, 'loginLog'],
        // ...其它事件处理函数...
    ],
    // 在服务停止时清理监听器跟踪
    'stop'                  => function () {
        \app\process\CacheableProcessor::clearListeners();
    }
];
