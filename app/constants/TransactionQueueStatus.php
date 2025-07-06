<?php

namespace app\constants;

use app\constants\lib\ConstantsOptionTrait;

class TransactionQueueStatus
{
    use ConstantsOptionTrait;

    // 状态:0-处理中 1-成功 2-失败 3-挂起(定时任务扫描长时间没处理，队列丢失)
    const STATUS_PROCESSING = 0;
    const STATUS_SUCCESS    = 1;
    const STATUS_FAIL       = 2;
    const STATUS_SUSPEND    = 3;
    public static array $status_list = [
        self::STATUS_PROCESSING => 'record.enums.status.0',
        self::STATUS_SUCCESS    => 'record.enums.status.1',
        self::STATUS_FAIL       => 'record.enums.status.2',
        self::STATUS_SUSPEND    => 'record.enums.status.3',
    ];
}
