<?php

namespace app\upstream\aipay;

use app\model\ModelChannelAccount;
use app\upstream\Handle\TransactionCollectionOrderInterface;
use JetBrains\PhpStorm\ArrayShape;

class CollectionService extends Base implements TransactionCollectionOrderInterface
{
    public function init(ModelChannelAccount $channel_account): TransactionCollectionOrderInterface
    {
        return $this;
    }

    #[ArrayShape([
        'ok'     => 'bool',
        'origin' => 'string',
        'data'   => [
            '_upstream_order_no' => 'string',
            '_order_amount'      => 'string',
            '_pay_url'           => 'string',
            '_utr'               => 'string'
        ]
    ])] public function createOrder(string $tenant_order_no, float $amount): array
    {
        // TODO: Implement createOrder() method.
    }

    public function queryOrder(string $tenant_order_no, string $upstream_order_no): array
    {
        // TODO: Implement queryOrder() method.
    }

    public function cancelOrder(string $tenant_order_no, string $upstream_order_no): bool
    {
        // TODO: Implement cancelOrder() method.
    }

    public function notify(array $params): array
    {
        // TODO: Implement notify() method.
    }

    public function notifyReturn(bool $success): mixed
    {
        // TODO: Implement notifyReturn() method.
    }

}
