<?php

return [
    'operation.log'         => [
        [\app\event\OperationEvent::class, 'process'],
    ],
    'backend.user.login'    => [
        [\http\backend\Service\PassportService::class, 'loginLog'],
        // ...其它事件处理函数...
    ],
//    // 系统配置更新的全局处理
//    'system_config_update' => [
//        [\app\event\SystemConfigEvent::class, 'Update']
//    ],

    // 在服务停止时清理监听器跟踪
    'stop'                  => function () {
        \app\process\CacheableProcessor::clearListeners();
    }
];
