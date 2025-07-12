<?php

namespace app\model;

use Carbon\Carbon;

/**
 * @property int $id 主键
 * @property int $channel_account_id 关联channel_account.id
 * @property int $bank_account_id 关联bank_account.id
 * @property int $channel_id 渠道ID
 * @property Carbon $stat_date 统计日期(YYYY-MM-DD)
 * @property int $transaction_count 当日交易总次数
 * @property int $success_count 成功交易次数
 * @property int $failure_count 失败交易次数
 * @property float $receipt_amount 当日已收款金额
 * @property float $payment_amount 当日已付款金额
 * @property float $success_rate 交易成功率(%)
 * @property int $avg_process_time 平均处理时间(ms)
 * @property int $limit_status 限额状态:0正常 1部分限额 2完全限额
 * @property Carbon $created_at 创建时间
 * @property Carbon $updated_at 更新时间
 */
final class ModelChannelAccountDailyStats extends BasicModel
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'channel_account_daily_stats';

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
        'channel_account_id',
        'bank_account_id',
        'channel_id',
        'stat_date',
        'transaction_count',
        'success_count',
        'failure_count',
        'receipt_amount',
        'payment_amount',
        'success_rate',
        'avg_process_time',
        'limit_status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'channel_account_id' => 'integer',
        'bank_account_id'    => 'integer',
        'channel_id'         => 'integer',
        'stat_date'          => 'date',
        'transaction_count'  => 'integer',
        'success_count'      => 'integer',
        'failure_count'      => 'integer',
        'receipt_amount'     => 'float',
        'payment_amount'     => 'float',
        'success_rate'       => 'float',
        'avg_process_time'   => 'integer',
        'limit_status'       => 'integer',
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
    ];
}
