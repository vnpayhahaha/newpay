<?php

namespace app\model;

use Carbon\Carbon;
use support\Model;

/**
 * @property int $id 主键
 * @property string $username 用户名
 * @property string $ip 登录IP地址
 * @property string $os 操作系统
 * @property string $browser 浏览器
 * @property int $status 登录状态 (1成功 2失败)
 * @property string $message 提示消息
 * @property Carbon $login_time 登录时间
 * @property string $remark 备注
 */
class ModelUserLoginLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_login_log';

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
        'ip',
        'os',
        'browser',
        'status',
        'message',
        'login_time',
        'remark',
    ];
}
