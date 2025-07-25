<?php

namespace app\upstream\Handle;

use app\model\ModelChannelAccount;
use JetBrains\PhpStorm\ArrayShape;

interface TransactionCollectionOrderInterface
{

    // 初始化配置
    public function init(ModelChannelAccount $channel_account): self;
    /**
     * 创建订单
     * @param string $tenant_order_no
     * @param float $amount
     * @return array result
     *   -- bool ok
     *   -- string origin (json原始返回数据)
     *   -- array data
     *      -- string _upstream_order_no
     *      -- string _order_amount
     *      -- string _pay_url
     *      -- string _utr
     */
    #[ArrayShape([
        'ok' => 'bool',
        'origin' => 'string',
        'data' => [
            '_upstream_order_no' => 'string',
            '_order_amount' => 'string',
            '_pay_url' => 'string',
            '_utr' => 'string'
        ]
    ])]
    public function createOrder(string $tenant_order_no, float $amount): array;

    // 查询订单详情
    public function queryOrder(string $tenant_order_no, string $upstream_order_no): array;

    // 取消订单
    public function cancelOrder(string $tenant_order_no, string $upstream_order_no): bool;
    // 接收通知

    /**
     * 回调通知
     * @return array result
     *   -- bool ok
     *   -- string origin (json原始返回数据)
     *   -- array data
     *      -- string _third_order_no
     *      -- string _order_out_no
     *      -- float _order_amount
     *      -- string _order_pay_time
     *      -- string _utr
     */
    public function notify(array $params): array;

    public function notifyReturn(bool $success): mixed;
}
