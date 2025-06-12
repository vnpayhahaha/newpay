<?php

return [
    'operation.log'      => [
        [\app\event\OperationEvent::class, 'process'],
    ],
    'backend.user.login'  => [
        [\http\backend\Service\PassportService::class, 'loginLog'],
        // ...其它事件处理函数...
    ],
];
