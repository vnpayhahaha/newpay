<?php

namespace app\model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use support\Model;

/**
* @property int $id 主键 主键
* @property string $tenant_id 租户编号
* @property string $app_name 应用名称
* @property string $app_key 应用ID
* @property string $app_secret 应用密钥
* @property int $status 状态 (1正常 2停用)
* @property string $description 应用介绍
* @property int $created_by 创建者
* @property Carbon $created_at 创建时间
* @property int $updated_by 更新者
* @property Carbon $updated_at 更新时间
* @property int $deleted_by 删除者
* @property Carbon $deleted_at 删除时间
* @property string $remark 备注
*/
final class ModelTenantApp extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'tenant_app';

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
        'app_name',
        'app_key',
        'app_secret',
        'status',
        'description',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
        'remark'
    ];
}
