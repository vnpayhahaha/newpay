<?php

namespace app\queue\redis\Notice;

use app\constants\TenantNotificationQueue;
use app\repository\TenantAccountRepository;
use app\repository\TenantNotificationQueueRepository;
use DI\Attribute\Inject;
use Webman\RedisQueue\Consumer;

class TenantNoticeConsumer implements Consumer
{
    // 要消费的队列名
    public string $queue = TenantNotificationQueue::TENANT_NOTIFICATION_QUEUE_NAME;

    // 连接名，对应 plugin/webman/redis-queue/redis.php 里的连接`
    public string $connection = 'default';

    #[Inject]
    protected TenantNotificationQueueRepository $tenantNotificationQueueRepository;

    // 消费

    /**
     * @param $data [
     * 'queue_id'              => $model->id,
     * 'tenant_id'             => $model->tenant_id,
     * 'app_id'                => $model->app_id,
     * 'account_type'          => $model->account_type,
     * 'disbursement_order_id' => $model->disbursement_order_id,
     * 'notification_type'     => $model->notification_type,
     * 'notification_url'      => $model->notification_url,
     * 'request_method'        => $model->request_method,
     * 'request_data'          => $model->request_data,
     * 'max_retry_count'       => $model->max_retry_count,
     * ]
     * @return void
     */
    public function consume($data)
    {
        dump('TenantNoticeConsumer===========run=====',$data);
    }
}