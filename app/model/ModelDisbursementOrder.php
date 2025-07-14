<?php

namespace app\model;

use Carbon\Carbon;

/**
 * @property int $id 主键
 * @property string $platform_order_no 平台订单号
 * @property string $merchant_order_no 下游订单号
 * @property string $upstream_order_no 上游订单号
 * @property Carbon $pay_time 支付时间
 * @property string $order_source 订单来源:App-API 管理后台 导入
 * @property int $disbursement_channel_id 代付渠道D
 * @property int $disbursement_bank_id 代付银行卡ID
 * @property float $amount 订单金额
 * @property float $paid_amount 订单实付金额
 * @property float $fixed_fee 固定手续费
 * @property float $rate_fee 费率手续费
 * @property float $total_fee 总手续费
 * @property float $settlement_amount 租户入账金额
 * @property float $upstream_fee 上游手续费
 * @property float $upstream_settlement_amount 上游结算金额
 * @property int $payment_type 付款类型:1-银行卡 2-UPI
 * @property string $payee_bank_name 收款人银行名称
 * @property string $payee_bank_code 收款人银行编码
 * @property string $payee_account_name 收款人账户姓名
 * @property string $payee_account_no 收款人银行卡号
 * @property string $payee_upi 收款人UPI账号
 * @property string $utr 实际交易的凭证/UTR
 * @property string $tenant_id 租户编号
 * @property int $app_id 应用ID
 * @property string $description 订单描述
 * @property int $status 订单状态:
 * 0-创建 10-待支付 11-待回填 20-成功 30-挂起
 * 40-失败 41-已取消 43-已失效 44-已退款
 * @property Carbon $expire_time 订单失效时间
 * @property string $callback_url 回调地址
 * @property int $callback_count 回调次数
 * @property int $notify_status 通知状态:0-未通知 1-通知成功 2-通知失败 3-回调中
 * @property string $channel_transaction_no 渠道交易号
 * @property string $error_code 错误代码
 * @property string $error_message 错误信息
 * @property string $request_id 关联API请求ID
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class ModelDisbursementOrder extends BasicModel
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'disbursement_order';

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
        'platform_order_no',
        'merchant_order_no',
        'upstream_order_no',
        'pay_time',
        'order_source',
        'disbursement_channel_id',
        'disbursement_bank_id',
        'amount',
        'paid_amount',
        'fixed_fee',
        'rate_fee',
        'total_fee',
        'settlement_amount',
        'upstream_fee',
        'upstream_settlement_amount',
        'payment_type',
        'payee_bank_name',
        'payee_bank_code',
        'payee_account_name',
        'payee_account_no',
        'payee_upi',
        'utr',
        'tenant_id',
        'app_id',
        'description',
        'status',
        'expire_time',
        'callback_url',
        'callback_count',
        'notify_status',
        'channel_transaction_no',
        'error_code',
        'error_message',
        'request_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'pay_time'                   => 'datetime',
        'disbursement_channel_id'    => 'integer',
        'disbursement_bank_id'       => 'integer',
        'amount'                     => 'float',
        'paid_amount'                => 'float',
        'fixed_fee'                  => 'float',
        'rate_fee'                   => 'float',
        'total_fee'                  => 'float',
        'settlement_amount'          => 'float',
        'upstream_fee'               => 'float',
        'upstream_settlement_amount' => 'float',
        'payment_type'               => 'integer',
        'app_id'                     => 'integer',
        'status'                     => 'integer',
        'expire_time'                => 'datetime',
        'callback_count'             => 'integer',
        'notify_status'              => 'integer',
        'created_at'                 => 'datetime',
        'updated_at'                 => 'datetime',
    ];
}
