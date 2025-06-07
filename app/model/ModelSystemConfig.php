<?php

namespace app\model;

use support\Model;

/**
* @property int $id 主键 配置ID
* @property string $group_code 分组编码
* @property string $code 唯一编码
* @property string $name 配置名称
* @property string $content 配置内容
* @property int $is_sys 是否系统
* @property int $enabled 是否启用
* @property int $created_at 创建时间
* @property int $created_by 创建用户
* @property int $updated_at 更新时间
* @property int $updated_by 更新用户
* @property int $deleted_at 是否删除
* @property string $remark 备注
*/
final class ModelSystemConfig extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'system_config';

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
        'group_code',
        'code',
        'name',
        'content',
        'is_sys',
        'enabled',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'remark'
    ];
}
