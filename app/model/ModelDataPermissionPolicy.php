<?php

namespace app\model;

use support\Model;

/**
* @property int $id 主键
* @property int $user_id 用户ID（与角色二选一）
* @property int $position_id 岗位ID（与用户二选一）
* @property string $policy_type 策略类型（DEPT_SELF, DEPT_TREE, ALL, SELF, CUSTOM_DEPT, CUSTOM_FUNC）
* @property int $is_default 是否默认策略（默认值：true）
* @property mixed $value 策略值
* @property \Carbon\Carbon $created_at
* @property \Carbon\Carbon $updated_at
* @property \Carbon\Carbon $deleted_at
*/
final class ModelDataPermissionPolicy extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'data_permission_policy';

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
        'user_id',
        'position_id',
        'policy_type',
        'is_default',
        'value',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
