<?php

namespace app\upstream\Handle;

use app\model\ModelChannelAccount;
use app\model\ModelDisbursementOrder;
use JetBrains\PhpStorm\ArrayShape;

interface TransactionPaymentOrderInterface
{
    // 初始化配置
    public function init(ModelChannelAccount $channel_account): self;
    // 创建订单

    /**
     * @param ModelDisbursementOrder $orderModel
     * @return array result
     * -- bool ok
     * -- string origin (json原始返回数据)
     * -- array data
     * -- string _upstream_order_no
     */
    #[ArrayShape([
        'ok'     => 'bool',
        'msg'    => 'string',
        'origin' => 'string',
        'data'   => [
            '_upstream_order_no' => 'string',
        ]
    ])]
    public function createOrder(ModelDisbursementOrder $orderModel): array;
    // 查询订单状态
    public function queryOrder(string $tenant_order_no, string $upstream_order_no): void;
    // 取消订单
    public function cancelOrder(string $third_order_no): bool;
    // 接收通知
    public function notify(array $params): bool;

    public function notifyReturn(bool $success): mixed;
}
