<?php

namespace app\model;

use app\model\lib\CustomSoftDeletes;
use Carbon\Carbon;
use support\Db;
use Webman\Event\Event;

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
 * @property int $user_num_limit 用户数量（-1不限制）
 * @property int $app_num_limit 应用数量（-1不限制）
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
 * @property int $settlement_type 入账类型(1:D0 2:D 3:T)
 * @property int $settlement_delay_days 入账延迟天数
 * @property boolean $auto_transfer 自动划扣(1是 0否)
 * @property string $receipt_fee_type 收款手续费类型(1固定 2费率)
 * @property float $receipt_fixed_fee 收款固定手续费金额
 * @property float $receipt_fee_rate 收款手续费费率(%)
 * @property string $payment_fee_type 付款手续费类型(1固定 2费率)
 * @property float $payment_fixed_fee 付款固定手续费金额
 * @property float $payment_fee_rate 付款手续费费率(%)
 */
final class ModelTenant extends BasicModel
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
        'user_num_limit',
        'app_num_limit',
        'is_enabled',
        'created_by',
        'created_at',
        'expired_at',
        'updated_by',
        'updated_at',
        'safe_level',
        'deleted_by',
        'deleted_at',
        'remark',
        'settlement_type',
        'settlement_delay_days',
        'auto_transfer',
        'receipt_fee_type',
        'receipt_fixed_fee',
        'receipt_fee_rate',
        'payment_fee_type',
        'payment_fixed_fee',
        'payment_fee_rate',
    ];

    protected $casts = [
        'id'                    => 'integer',
        'account_count'         => 'integer',
        'is_enabled'            => 'boolean',
        'user_num_limit'        => 'integer',
        'app_num_limit'         => 'integer',
        'created_by'            => 'integer',
        'created_at'            => 'datetime',
        'updated_at'            => 'datetime',
        'expired_at'            => 'datetime',
        'deleted_at'            => 'datetime',
        'auto_transfer'         => 'boolean',
        'settlement_type'       => 'integer',
        'settlement_delay_days' => 'integer',
        'receipt_fee_type'      => 'array',
        'receipt_fixed_fee'     => 'float',
        'receipt_fee_rate'      => 'float',
        'payment_fee_type'      => 'array',
        'payment_fixed_fee'     => 'float',
        'payment_fee_rate'      => 'float',
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

        ModelTenant::created(function (ModelTenant $model) {
            Event::dispatch('app.tenant.created', $model);
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
