<?php

namespace app\upstream\Handle;

interface TransactionPaymentOrderInterface
{
    // 创建订单
    public function createOrder(int $order_id): bool;
    // 查询订单状态
    public function queryOrder(string $tenant_order_no, string $upstream_order_no): void;
    // 取消订单
    public function cancelOrder(string $third_order_no): bool;
    // 接收通知
    public function notify(array $params): bool;

    public function notifyReturn(bool $success): mixed;
}
