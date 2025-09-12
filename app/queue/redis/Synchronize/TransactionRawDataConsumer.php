<?php

namespace app\queue\redis\Synchronize;

use app\constants\TenantAccount;
use app\exception\UnprocessableEntityException;
use app\lib\enum\ResultCode;
use app\service\TransactionRawDataService;
use DI\Attribute\Inject;
use support\Log;
use Webman\RedisQueue\Consumer;

class TransactionRawDataConsumer implements Consumer
{
    // 要消费的队列名
    public string $queue = TenantAccount::TRANSACTION_CONSUMER_QUEUE_NAME;

    // 连接名，对应 plugin/webman/redis-queue/redis.php 里的连接`
    public string $connection = 'synchronize';

    #[Inject]
    protected TransactionRawDataService $service;

    // 消费
    // [
    //            'channel_id'      => [
    //                'required',
    //                'integer',
    //                'between:1,99999999999'
    //            ],
    //            'bank_account_id' => [
    //                'required',
    //                'integer',
    //                'between:1,99999999999'
    //            ],
    //            'content'         => [
    //                'required',
    //                'string',
    //                'max:65535',
    //            ],
    //            'source'          => 'required|string|max:255',
    //        ]
    public function consume($data)
    {
        if (!is_array($data)) {
            return false;
        }
        // 验证参数
        $validator = validate($data, [
            'channel_id'      => [
                'required',
                'integer',
                'between:1,99999999999'
            ],
            'bank_account_id' => [
                'required',
                'integer',
                'between:1,99999999999'
            ],
            'content'         => [
                'required',
                'string',
                'max:65535',
            ],
            'source'          => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            Log::error('TransactionRawDataConsumer: 参数验证失败', [$validator->errors()->first()]);
            return false;
        }
        $validatedData = $validator->validate();
        // 验证hash是否存在
        $hash = md5($validatedData['content']);
        if ($find = $this->service->repository->getQuery()->where('hash', $hash)->first()) {
            $find->increment('repeat_count');
            Log::warning('TransactionRawDataConsumer: 数据已存在', [$find->toArray()]);
            return false;
        }
        $this->service->create($validatedData);
        return true;
    }
}