<?php

namespace app\model;

use Carbon\Carbon;

/**
 * @property int $id 主键
 * @property int $queue_id 队列ID
 * @property string $tenant_id 租户编号
 * @property int $app_id 应用ID
 * @property int $order_id 订单ID
 * @property string $callback_url 回调地址
 * @property int $callback_type 回调类型:1-支付结果 2-退款结果 3-账单通知
 * @property string $request_data 请求数据
 * @property int $response_status 响应状态码
 * @property string $response_data 响应数据
 * @property int $retry_count 重试次数
 * @property Carbon $next_retry_time 下次重试时间
 * @property int $callback_status 回调状态:0-待回调 1-成功 2-失败 3-重试中
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class ModelTenantNotificationRecord extends BasicModel
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'tenant_notification_record';

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
        'queue_id',
        'tenant_id',
        'app_id',
        'order_id',
        'callback_url',
        'callback_type',
        'request_data',
        'response_status',
        'response_data',
        'retry_count',
        'next_retry_time',
        'callback_status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'queue_id'        => 'integer',
        'app_id'          => 'integer',
        'order_id'        => 'integer',
        'callback_type'   => 'integer',
        'response_status' => 'integer',
        'retry_count'     => 'integer',
        'callback_status' => 'integer',
    ];
}
