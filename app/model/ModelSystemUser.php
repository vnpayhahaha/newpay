<?php

namespace app\model;

use support\Model;

/**
* @property int $id 主键 用户ID，主键
* @property string $username 用户名
* @property string $password 密码
* @property string $user_type 用户类型：(100系统用户)
* @property string $nickname 用户昵称
* @property string $phone 手机
* @property string $email 用户邮箱
* @property string $avatar 用户头像
* @property string $signed 个人签名
* @property string $dashboard 后台首页类型
* @property int $status 状态 (1正常 2停用)
* @property string $login_ip 最后登陆IP
* @property \Carbon\Carbon $login_time 最后登陆时间
* @property string $backend_setting 后台设置数据
* @property int $created_by 创建者
* @property int $updated_by 更新者
* @property \Carbon\Carbon $created_at 创建时间
* @property \Carbon\Carbon $updated_at 更新时间
* @property \Carbon\Carbon $deleted_at 删除时间
* @property string $remark 备注
* @property int $is_google_verify 是否google验证(1yes 2no)
* @property string $google_secret_key Google验证密钥
* @property int $is_google_bind 是否已绑定Google验证(1yes 2no)
*/
final class ModelSystemUser extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'system_user';

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
        'username',
        'password',
        'user_type',
        'nickname',
        'phone',
        'email',
        'avatar',
        'signed',
        'dashboard',
        'status',
        'login_ip',
        'login_time',
        'backend_setting',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'remark',
        'is_google_verify',
        'google_secret_key',
        'is_google_bind'
    ];
}
