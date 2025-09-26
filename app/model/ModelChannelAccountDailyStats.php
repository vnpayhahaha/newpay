<?php

namespace app\model;

use Carbon\Carbon;

/**
* @property int $id 主键
* @property int $channel_account_id 关联channel_account.id
* @property int $bank_account_id 关联bank_account.id
* @property int $channel_id 渠道ID
* @property Carbon $stat_date 统计日期(YYYY-MM-DD)
* @property int $collection_transaction_count 当日收款交易总次数
* @property int $disbursement_transaction_count 当日付款交易总次数
* @property int $collection_success_count 收款成功交易次数
* @property int $collection_failure_count 收款失败交易次数
* @property int $disbursement_success_count 付款成功交易次数
* @property int $disbursement_failure_count 付款失败交易次数
* @property float $receipt_amount 当日已收款金额
* @property float $payment_amount 当日已付款金额
* @property float $collection_success_rate 收款交易成功率(%)
* @property float $disbursement_success_rate 付款交易成功率(%)
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
        'collection_transaction_count',
        'disbursement_transaction_count',
        'collection_success_count',
        'collection_failure_count',
        'disbursement_success_count',
        'disbursement_failure_count',
        'receipt_amount',
        'payment_amount',
        'collection_success_rate',
        'disbursement_success_rate',
        'avg_process_time',
        'limit_status',
        'created_at',
        'updated_at'
    ];
}
