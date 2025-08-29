<?php

namespace app\queue\redis\Notice;

use app\constants\TenantNotificationQueue;
use Webman\RedisQueue\Consumer;

class TenantNoticeConsumer implements Consumer
{
    // 要消费的队列名
    public string $queue = TenantNotificationQueue::TENANT_NOTIFICATION_QUEUE_NAME;

    // 连接名，对应 plugin/webman/redis-queue/redis.php 里的连接`
    public string $connection = 'default';

    // 消费
    public function consume($data)
    {
        dump('TenantNoticeConsumer===========run=====',$data);
    }
}