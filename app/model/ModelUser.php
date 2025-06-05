<?php

namespace app\model;

use app\model\enums\Status;
use app\model\enums\UserType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use support\Model;

/**
 * @property int $id 用户ID，主键
 * @property string $username 用户名
 * @property int $user_type 用户类型：(100系统用户)
 * @property string $nickname 用户昵称
 * @property string $phone 手机
 * @property string $email 用户邮箱
 * @property string $avatar 用户头像
 * @property string $signed 个人签名
 * @property int $status 状态 (1正常 2停用)
 * @property string $login_ip 最后登陆IP
 * @property string $login_time 最后登陆时间
 * @property array $backend_setting 后台设置数据
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 * @property string $remark 备注
 * @property null|Collection|ModelRole[] $roles
 * @property mixed $password 密码
 * @property null|ModelPolicy $policy 数据权限策略
 * @property Collection|ModelDepartment[] $department 部门
 * @property Collection|ModelDepartment[] $dept_leader 部门领导
 * @property Collection|ModelPosition[] $position 岗位
 */
final class ModelUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

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

    protected $hidden = ['password'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'username',
        'user_type',
        'nickname',
        'phone',
        'email',
        'avatar',
        'signed',
        'status',
        'login_ip',
        'login_time',
        'backend_setting',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'remark',
    ];

    public function roles(): BelongsToMany
    {
        // @phpstan-ignore-next-line
        return $this->belongsToMany(
            ModelRole::class,
            // @phpstan-ignore-next-line
            'user_belongs_role',
        );
    }

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = password_hash((string)$value, \PASSWORD_DEFAULT);
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function resetPassword(): void
    {
        $this->password = 123456;
    }

    public function isSuperAdmin(): bool
    {
        return $this->roles()->where('code', 'SuperAdmin')->exists();
    }

    public function getRoles(array $fields): Collection
    {
        return $this->roles()
            ->where('status', Status::Normal)
            ->select($fields)
            ->get();
    }

    public function getPermissions(): Collection
    {
        return $this->roles()->with('menus')->orderBy('sort')->get()->pluck('menus')->flatten();
    }

    public function hasPermission(string $permission): bool
    {
        return $this->roles()->whereRelation('menus', 'name', $permission)->exists();
    }

    public function policy(): HasOne
    {
        return $this->hasOne(ModelPolicy::class, 'user_id', 'id');
    }

    public function department(): BelongsToMany
    {
        return $this->belongsToMany(ModelDepartment::class, 'user_dept', 'user_id', 'dept_id');
    }

    public function dept_leader(): BelongsToMany
    {
        return $this->belongsToMany(ModelDepartment::class, 'dept_leader', 'user_id', 'dept_id');
    }

    public function position(): BelongsToMany
    {
        return $this->belongsToMany(ModelPosition::class, 'user_position', 'user_id', 'position_id');
    }

    public function getPolicy(): ?ModelPolicy
    {
        /**
         * @var null|ModelPolicy $policy
         */
        $policy = $this->policy()->first();
        if (!empty($policy)) {
            return $policy;
        }

        $this->load('position');
        $positionList = $this->position;
        foreach ($positionList as $position) {
            $current = $position->policy()->first();
            if (!empty($current)) {
                return $current;
            }
        }
        return null;
    }
}
