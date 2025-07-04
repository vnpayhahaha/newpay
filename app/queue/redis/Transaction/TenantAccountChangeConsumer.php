<?php

namespace app\queue\redis\Transaction;

use app\constants\TenantAccount;
use Webman\RedisQueue\Consumer;

class TenantAccountChangeConsumer implements Consumer
{
    // 要消费的队列名
    public string $queue = TenantAccount::CHANGE_QUEUE_NAME;

    // 连接名，对应 plugin/webman/redis-queue/redis.php 里的连接`
    public string $connection = 'default';

    // 消费
    public function consume($data)
    {
        var_dump('bill_change_consumer == run ==');
        // 无需反序列化
        var_export($data);
    }

    public function onConsumeFailure(\Throwable $e, $package)
    {
        echo "bill_change_consumer failure\n";
        echo $e->getMessage() . "\n";
        // 无需反序列化
        var_export($package);
    }

}
