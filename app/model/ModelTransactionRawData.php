<?php

namespace app\model;

use Carbon\Carbon;

/**
* @property int $id 主键 自增id
* @property string $hash 哈希值
* @property string $content 内容
* @property string $source 来源
* @property int $status 状态：0未解析 1解析成功 2解析失败
* @property int $repeat_count 计数
* @property Carbon $created_at 创建时间
* @property Carbon $updated_at 更新时间
*/
final class ModelTransactionRawData extends BasicModel
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'transaction_raw_data';

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
        'hash',
        'content',
        'source',
        'status',
        'repeat_count',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'id'            => 'integer',
        'status'        => 'integer',
        'repeat_count'  => 'integer',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(static function (ModelTransactionRawData $model) {
            $model->hash = md5($model->content);
        });
    }
}
