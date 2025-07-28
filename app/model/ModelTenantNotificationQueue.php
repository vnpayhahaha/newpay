<?php

namespace app\model;

use Carbon\Carbon;

/**
 * @property int $id 主键
 * @property int $callback_id 回调记录ID
 * @property int $execute_status 执行状态:
 * 0-待执行 1-执行中 2-成功 3-失败
 * @property int $execute_count 执行次数
 * @property Carbon $next_execute_time 下次执行时间
 * @property Carbon $last_execute_time 最后执行时间
 * @property string $error_message 错误信息
 * @property Carbon $created_at
 * @property Carbon $updated_at
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
        'callback_id',
        'execute_status',
        'execute_count',
        'next_execute_time',
        'last_execute_time',
        'error_message',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'callback_id'       => 'integer',
        'execute_status'    => 'integer',
        'execute_count'     => 'integer',
        'next_execute_time' => 'datetime',
        'last_execute_time' => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime'
    ];
}
