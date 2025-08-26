<?php

namespace app\model;

use Carbon\Carbon;

/**
 * @property int $id 主键
 * @property string $platform_order_no 平台订单号
 * @property float $amount 支付金额
 * @property string $utr UTR
 * @property int $payment_status 支付状态:0未支付1支付成功2支付失败
 * @property mixed $order_data 订单数据
 * @property int $process_status 处理状态:
 * 0-待处理 1-处理中 2-成功 3-失败
 * @property int $retry_count 重试次数
 * @property Carbon $next_retry_time 下次重试时间
 * @property string $rejection_reason 拒绝原因
 * @property Carbon $created_at
 * @property Carbon $processed_at
 */
final class ModelDisbursementOrderVerificationQueue extends BasicModel
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'disbursement_order_verification_queue';

    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'id';

    // updated_at = processed_at
    public const UPDATED_AT = 'processed_at';


    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'platform_order_no',
        'amount',
        'utr',
        'order_data',
        'process_status',
        'retry_count',
        'next_retry_time',
        'rejection_reason',
        'created_at',
        'processed_at',
        'payment_status',
    ];

    protected $casts = [
        'process_status' => 'integer',
        'retry_count'    => 'integer',
        'payment_status' => 'integer',
        'order_data'     => 'json',
        'created_at'     => 'datetime',
        'processed_at'   => 'datetime',
    ];
}
