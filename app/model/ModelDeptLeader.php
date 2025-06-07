<?php

namespace app\model;

use support\Model;

/**
* @property int $dept_id
* @property int $user_id
* @property \Carbon\Carbon $created_at
* @property \Carbon\Carbon $updated_at
* @property \Carbon\Carbon $deleted_at
*/
final class ModelDeptLeader extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'dept_leader';

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
        'dept_id',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
