<?php

namespace app\model;

use Carbon\Carbon;

/**
 * @property int $id 主键 ID
 * @property string $tenant_id 租户编号
 * @property float $balance_available 可用余额
 * @property float $balance_frozen 冻结金额
 * @property int $account_type 账户类型:10-收款账户 20-付款账户
 * @property int $version 乐观锁版本
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 */
final class ModelTenantAccount extends BasicModel
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'tenant_account';

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
        'balance_available',
        'balance_frozen',
        'account_type',
        'version',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'id'                => 'string',
        'tenant_id'         => 'string',
        'balance_available' => 'decimal:2',
        'balance_frozen'    => 'decimal:2',
        'account_type'      => 'integer',
        'version'           => 'string',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

}
