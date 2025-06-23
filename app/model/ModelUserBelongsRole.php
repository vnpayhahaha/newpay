<?php

namespace app\model;

use Carbon\Carbon;

/**
* @property int $id 主键
* @property int $user_id 用户id
* @property int $role_id 角色id
* @property Carbon $created_at
* @property Carbon $updated_at
*/
final class ModelUserBelongsRole extends BasicModel
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'user_belongs_role';

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
        'role_id',
        'created_at',
        'updated_at'
    ];
}
