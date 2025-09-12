<?php

namespace app\upstream\aipay;

use app\model\ModelChannelAccount;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use support\Log;

class Base
{

    protected ModelChannelAccount $channel_account;

    protected string $service_name = 'aipay';
    protected string $url = 'https://top.adkjk.in/aipay-api';
    protected string $collection_notify_url;
    protected string $payment_notify_url;
    protected string $secret_key = 'abc#123!';
    protected int $merchant_id = 999;
    protected string $return_url = 'https://www.google.com';

    /**
     * @throws \Throwable
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function post(string $uri, array $data): mixed
    {
        var_dump($this->service_name .'===post==', $uri, $data);
        try {
            $client = new Client();
            $body = json_encode($data, JSON_THROW_ON_ERROR);
            $options = [
                'timeout' => 30,
                'headers' => [
                    'Content-Type' => 'application/json;charset=utf-8',
                ],
                'body'    => $body,
            ];
            $urlPath = $this->url . $uri;
            $response = $client->request('POST', $urlPath, $options);
            var_dump('===getStatusCode==', $response->getStatusCode());
            $response_result = $response->getBody()->getContents();
            var_dump('===response_result==', $response_result);
            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 202) {
                return json_decode($response_result, true, 512, JSON_THROW_ON_ERROR);
            }
            throw new \RuntimeException($this->service_name . ' 接口异常:' . $response_result);
        } catch (\Throwable $e) {
            $errMsg = $e->getMessage();
            Log::error("{$this->service_name} post 请求异常[{$this->url}]：" . $errMsg, [$e]);
            throw $e;
        }
    }
}
