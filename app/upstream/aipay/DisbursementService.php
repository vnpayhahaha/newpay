<?php

namespace app\upstream\aipay;

use app\model\ModelChannelAccount;
use app\model\ModelDisbursementOrder;
use app\upstream\Handle\TransactionPaymentOrderInterface;
use JetBrains\PhpStorm\ArrayShape;

class DisbursementService  extends Base implements TransactionPaymentOrderInterface
{
    public function init(ModelChannelAccount $channel_account): TransactionPaymentOrderInterface
    {
        $this->channel_account = $channel_account;
        $api_config_array = $this->channel_account->api_config;
        if (!filled($api_config_array)) {
            throw new \RuntimeException('Interface parameters not configured');
        }
        foreach ($api_config_array as $item) {
            if ($item['label'] === 'secret_key') {
                $this->secret_key = $item['value'];
            } elseif ($item['label'] === 'url') {
                $this->url = $item['value'];
            } elseif ($item['label'] === 'merchant_id') {
                $this->merchant_id = (int)$item['value'];
            } elseif ($item['label'] === 'return_url') {
                $this->return_url = $item['value'];
            }
        }
        return $this;
    }
    #[ArrayShape([
        'ok'     => 'bool',
        'msg'    => 'string',
        'origin' => 'string',
        'data'   => [
            '_upstream_order_no' => 'string',
        ]
    ])]
    public function createOrder(ModelDisbursementOrder $orderModel): array
    {
        // TODO: Implement createOrder() method.
    }

    public function queryOrder(string $tenant_order_no, string $upstream_order_no): void
    {
        // TODO: Implement queryOrder() method.
    }

    public function cancelOrder(string $third_order_no): bool
    {
        // TODO: Implement cancelOrder() method.
    }

    public function notify(array $params): bool
    {
        // TODO: Implement notify() method.
    }

    public function notifyReturn(bool $success): mixed
    {
        // TODO: Implement notifyReturn() method.
    }

}