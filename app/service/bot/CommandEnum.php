<?php

namespace app\service\bot;

class CommandEnum
{

    public const TELEGRAM_COMMAND_RUN_QUEUE_NAME = 'telegram-command-run-queue';
    public const TELEGRAM_NOTICE_QUEUE_NAME = 'telegram-notice-queue';
    // 定义中文指令集
    public const COMMAND_SET_CN = [
        '开始'         => 'start',
        '帮助'         => 'help',
        '获取ID'       => 'get-id',
        '获取群ID'     => 'get-group-id',
        '绑定'         => 'bind',
        '查询'         => 'query',
        '查询订单'     => 'order',
        '查询收款订单' => 'query-collect-order',
        '查询付款订单' => 'query-pay-order',
        '创建付款订单' => 'create-order',
        '提交UTR补单'  => 'submit-utr',
        '统计收款订单' => 'count-collect-order',
        '统计付款订单' => 'count-pay-order',
    ];

    public const COMMAND_SET = [
        'start'               => 'Start',
        'help'                => 'Help',
        'get-id'              => 'GetId',
        'get-group-id'        => 'GetGroupId',
        'bind'                => 'Bind',
        // 1
        'query'               => 'Query', //1
        'order'               => 'Order',
        'query-collect-order' => 'QueryCollectOrder',
        'query-pay-order'     => 'QueryPayOrder',
        'create-order'        => 'CreateOrder',
        'submit-utr'          => 'SubmitUtr',
        //1
        'count-collect-order' => 'CountCollectOrder',
        'count-pay-order'     => 'CountPayOrder',
    ];

    // 是否是命令
    public static function isCommand(string $command): bool
    {
        return in_array($command, self::COMMAND_SET_CN) || in_array($command, self::COMMAND_SET);
    }

    public static function getCommand(string $command): string
    {
        if (in_array($command, self::COMMAND_SET_CN)) {
            return self::COMMAND_SET[self::COMMAND_SET_CN[$command]];
        }
        if (in_array($command, self::COMMAND_SET)) {
            return self::COMMAND_SET[$command];
        }
        return '';
    }
}
