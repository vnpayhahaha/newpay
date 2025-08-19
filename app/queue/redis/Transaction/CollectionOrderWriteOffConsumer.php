<?php

namespace app\queue\redis\Transaction;

use app\constants\CollectionOrder;
use Webman\RedisQueue\Consumer;

class CollectionOrderWriteOffConsumer implements Consumer
{
    // 要消费的队列名
    public string $queue = CollectionOrder::COLLECTION_ORDER_WRITE_OFF_QUEUE_NAME;

    // 连接名，对应 plugin/webman/redis-queue/redis.php 里的连接`
    public string $connection = 'default';
    public function consume($data)
    {
        var_dump('CollectionOrderWriteOffConsumer===',$data);
    }

}