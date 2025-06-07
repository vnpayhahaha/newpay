<?php

return [
    'backend.user.login'  => [
        [\backend\Service\PassportService::class, 'loginLog'],
        // ...其它事件处理函数...
    ],
];
