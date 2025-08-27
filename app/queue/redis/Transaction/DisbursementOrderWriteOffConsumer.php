<?php

namespace app\queue\redis\Transaction;

use app\constants\DisbursementOrder;
use app\service\DisbursementOrderService;
use app\service\TransactionVoucherService;
use DI\Attribute\Inject;
use Webman\RedisQueue\Consumer;

class DisbursementOrderWriteOffConsumer  implements Consumer
{
    // 要消费的队列名
    public string $queue = DisbursementOrder::DISBURSEMENT_ORDER_WRITE_OFF_QUEUE_NAME;

    // 连接名，对应 plugin/webman/redis-queue/redis.php 里的连接`
    public string $connection = 'default';

    #[Inject]
    protected DisbursementOrderService $disbursementOrderService;

    #[Inject]
    protected TransactionVoucherService $transactionVoucherService;

    /**
     * @throws Exception
     */
    public function consume($data): void
    {
        var_dump('DisbursementOrderWriteOffConsumer=========================start',$data);
    }
}