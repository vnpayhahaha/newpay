<?php

namespace app\model;

use app\model\lib\CustomSoftDeletes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use support\Db;
use support\Model;

/**
 * @property int $id 主键 id
 * @property string $tenant_id 租户编号
 * @property string $contact_user_name 联系人
 * @property string $contact_phone 联系电话
 * @property string $company_name 企业名称
 * @property string $license_number 企业代码
 * @property string $address 地址
 * @property string $intro 企业简介
 * @property string $domain 域名
 * @property int $account_count 用户数量（-1不限制）
 * @property bool $is_enabled 启用状态(1正常 2停用)
 * @property int $created_by 创建管理员
 * @property Carbon $created_at 创建时间
 * @property Carbon $expired_at 过期时间
 * @property int $updated_by 更新者
 * @property Carbon $updated_at 更新时间
 * @property int $safe_level 安全等级(0-99)
 * @property int $deleted_by 删除者
 * @property Carbon $deleted_at 删除时间
 * @property string $remark 备注
 */
final class ModelTenant extends Model
{

    use CustomSoftDeletes;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'tenant';

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
        'contact_user_name',
        'contact_phone',
        'company_name',
        'license_number',
        'address',
        'intro',
        'domain',
        'account_count',
        'is_enabled',
        'created_by',
        'created_at',
        'expired_at',
        'updated_by',
        'updated_at',
        'safe_level',
        'deleted_by',
        'deleted_at',
        'remark'
    ];

    protected $casts = [
        'id'            => 'integer',
        'account_count' => 'integer',
        'is_enabled'    => 'boolean',
        'created_by'    => 'integer',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'expired_at'    => 'datetime',
        'deleted_at'    => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        ModelTenant::creating(function (ModelTenant $model) {
            var_dump('run  creating==');
            if (empty($model->tenant_id)) {
                // 获取当前最大ID
                $maxId = Db::table($model->table)
                    ->max(Db::raw('CAST(tenant_id AS UNSIGNED)'));

                $nextId = $maxId + 1;
                $model->tenant_id = str_pad($nextId, 6, '0', STR_PAD_LEFT);
            }
        });

        ModelTenant::updating(function (ModelTenant $model) {
            $model->updated_by = request()->user->id ?? 0;
        });

        ModelTenant::deleting(function (ModelTenant $model) {
            if ($model->isForceDeleting()) {
                return; // 硬删除不记录
            }
            // 从请求或上下文获取删除者ID（示例）
            $deletedBy = request()->user->id ?? 0;
            $model->deleted_by = $deletedBy;
        });
    }
}
