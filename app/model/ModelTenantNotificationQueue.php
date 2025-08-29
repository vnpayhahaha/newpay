<?php

namespace app\model;

use app\constants\TenantNotificationQueue;
use Carbon\Carbon;
use Webman\RedisQueue\Redis;

/**
 * @property int $id 主键
 * @property string $tenant_id 租户编号
 * @property int $app_id 应用ID
 * @property int $account_type 账户变动类型（继承tenant_account类型1-收款账户 2-付款账户）
 * @property int $collection_order_id 收款订单ID
 * @property int $disbursement_order_id 付款订单ID
 * @property int $notification_type 通知类型:1-支付结果 2-退款结果 3-账单通知
 * @property string $notification_url 通知地址
 * @property string $request_method 请求方式
 * @property string $request_data 请求数据
 * @property int $execute_status 执行状态:0-待执行 1-执行中 2-成功 3-失败
 * @property int $execute_count 执行次数
 * @property Carbon $next_execute_time 下次执行时间
 * @property Carbon $last_execute_time 最后执行时间
 * @property string $error_message 错误信息
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $max_retry_count 最大尝试次数
 */
final class ModelTenantNotificationQueue extends BasicModel
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'tenant_notification_queue';

    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'tenant_id',
        'app_id',
        'account_type',
        'collection_order_id',
        'disbursement_order_id',
        'notification_type',
        'notification_url',
        'request_method',
        'request_data',
        'execute_status',
        'execute_count',
        'next_execute_time',
        'last_execute_time',
        'error_message',
        'created_at',
        'updated_at',
        'max_retry_count',
    ];

    protected $casts = [
        'id'                    => 'integer',
        'tenant_id'             => 'string',
        'app_id'                => 'integer',
        'account_type'          => 'integer',
        'collection_order_id'   => 'integer',
        'disbursement_order_id' => 'integer',
        'notification_type'     => 'integer',
        'notification_url'      => 'string',
        'execute_count'         => 'string',
        'request_method'        => 'string',
        'request_data'          => 'json',
        'execute_status'        => 'integer',
        'next_execute_time'     => 'datetime',
        'last_execute_time'     => 'datetime',
        'error_message'         => 'string',
        'created_at'            => 'datetime',
        'updated_at'            => 'datetime',
        'max_retry_count'       => 'integer',
    ];

    public static function boot(): void
    {
        parent::boot();

        self::created(static function (ModelTenantNotificationQueue $model) {
            // 待付核销队列 TenantNotificationQueue
            if ($model->execute_status === TenantNotificationQueue::EXECUTE_STATUS_WAITING) {
                var_dump('待执行回调通知队列 TenantNotificationQueue');
                Redis::send(TenantNotificationQueue::TENANT_NOTIFICATION_QUEUE_NAME, [
                    'queue_id'              => $model->id,
                    'tenant_id'             => $model->tenant_id,
                    'app_id'                => $model->app_id,
                    'account_type'          => $model->account_type,
                    'disbursement_order_id' => $model->disbursement_order_id,
                    'notification_type'     => $model->notification_type,
                    'notification_url'      => $model->notification_url,
                    'request_method'        => $model->request_method,
                    'request_data'          => $model->request_data,
                    'max_retry_count'       => $model->max_retry_count,
                ]);
            }

        });
    }

}
