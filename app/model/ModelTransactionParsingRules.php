<?php

namespace app\model;

/**
* @property int $id 主键 自增id
* @property int $channel_id 渠道ID
* @property string $regex 正则表达式
* @property string $variable_name 提取变量名
* @property string $example_data 示例数据
* @property int $status 状态：1启用 0禁用
* @property \Carbon\Carbon $created_at 创建时间
* @property \Carbon\Carbon $updated_at 更新时间
* @property \Carbon\Carbon $deleted_at 删除时间
*/
final class ModelTransactionParsingRules extends BasicModel
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'transaction_parsing_rules';

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
        'channel_id',
        'regex',
        'variable_name',
        'example_data',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
