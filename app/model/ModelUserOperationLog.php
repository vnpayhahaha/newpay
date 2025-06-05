<?php

namespace app\model;

use Carbon\Carbon;
use support\Model;

/**
 * @property int $id
 * @property string $username 用户名
 * @property string $method 请求方式
 * @property string $router 请求路由
 * @property string $service_name 业务名称
 * @property string $ip 请求IP地址
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 * @property string $remark 备注
 */
class ModelUserOperationLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_operation_log';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'username',
        'method',
        'router',
        'service_name',
        'ip',
        'created_at',
        'updated_at',
        'remark',
    ];
}
