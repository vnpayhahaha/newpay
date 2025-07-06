<?php

namespace app\queue\redis\failed;


use support\Redis;
use Workerman\RedisQueue\Client;
use Workerman\Timer;

class FailedConsumer
{
    public function onWorkerStart()
    {
        // 每隔10秒检查一次数据库是否有新用户注册
        Timer::add(10, function(){
//            RedisQueue::QUEUE_FAILED;
            $failedKey = Client::QUEUE_FAILED;
            Redis::connection('queue')->set('test', 1,15);
            $getRedis = Redis::connection('queue')->rPop($failedKey);
            var_dump('每隔10秒检查一次数据:'.$failedKey,$getRedis);
        });
    }
}
