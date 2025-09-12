<?php

namespace app\upstream\aipay;

use app\model\ModelChannelAccount;
use app\upstream\Handle\TransactionCollectionOrderInterface;
use JetBrains\PhpStorm\ArrayShape;
use support\Response;

class CollectionService extends Base implements TransactionCollectionOrderInterface
{
    public function init(ModelChannelAccount $channel_account): TransactionCollectionOrderInterface
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
            '_order_amount'      => 'string',
            '_pay_upi'           => 'string',
            '_pay_url'           => 'string',
            '_utr'               => 'string'
        ]
    ])]
    public function createOrder(string $tenant_order_no, float $amount): array
    {
       try{
           $result = $this->post('/api/v1/payments', []);
       }catch (\Throwable $e){
           return ['ok' => false, 'msg' => $e->getMessage()];
       }
       return [
           'ok'     => true,
           'msg'    => 'success',
           'origin' => $result,
           'data'   => [
               '_upstream_order_no' => $result['data']['order_id'],
               '_order_amount'      => $result['data']['amount'],
               '_pay_upi'           => $result['data']['upi'],
               '_pay_url'           => $result['data']['pay_url'],
               '_utr'               => $result['data']['utr']
           ]
       ];
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

    public function notifyReturn(bool $success): Response
    {
        return $success ? response('success') : response('fail');
    }

}
