<?php

namespace app\model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use support\Model;

/**
 * @property int $user_id 主键 用户ID
 * @property string $tenant_id 租户编号
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $phone 手机号码
 * @property string $avatar 头像
 * @property string $last_login_ip 最后登陆IP
 * @property Carbon $last_login_time 最后登陆时间
 * @property int $status 状态(1正常 2停用)
 * @property int $is_enabled_google google验证(1正常 2停用)
 * @property string $google_secret_key Google验证密钥
 * @property int $is_bind_google 是否已绑定Google验证(1yes 2no)
 * @property int $created_by 创建者
 * @property Carbon $created_at 创建时间
 * @property int $updated_by 更新者
 * @property Carbon $updated_at 更新时间
 * @property int $deleted_by 删除者
 * @property Carbon $deleted_at 删除时间
 * @property string $ip_whitelist IP白名单
 * @property string $remark 备注
 */
final class ModelTenantUser extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'tenant_user';

    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'user_id',
        'tenant_id',
        'username',
        'password',
        'phone',
        'avatar',
        'last_login_ip',
        'last_login_time',
        'status',
        'is_enabled_google',
        'google_secret_key',
        'is_bind_google',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
        'ip_whitelist',
        'remark'
    ];

    protected $casts = [
        'user_id'           => 'integer',
        'last_login_time'   => 'datetime',
        'status'            => 'integer',
        'is_enabled_google' => 'integer',
        'is_bind_google'    => 'integer',
        'created_by'        => 'integer',
        'created_at'        => 'datetime',
        'updated_by'        => 'integer',
        'updated_at'        => 'datetime',
        'deleted_by'        => 'integer',
        'deleted_at'        => 'datetime',
    ];


    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = password_hash((string)$value, \PASSWORD_DEFAULT);
    }

    public function resetPassword(): void
    {
        var_dump('---setPasswordAttribute--');
        $this->password = 123456;
    }

}
