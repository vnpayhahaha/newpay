<?php

namespace app\service\bot;

class CommandEnum
{

    public const TELEGRAM_COMMAND_RUN_QUEUE_NAME = 'telegram-command-run-queue';
    public const TELEGRAM_NOTICE_QUEUE_NAME = 'telegram-notice-queue';
    // 定义中文指令集
    public const COMMAND_SET = [
        'start'               => 'Start',
        'help'                => 'Help',
        'get-id'              => 'GetId',
        'get-group-id'        => 'GetGroupId',
        'bind'                => 'Bind',
        // 1
        'query'               => 'Query',
        //1
        'order'               => 'Order',
        'query-collect-order' => 'QueryCollectOrder',
        'query-pay-order'     => 'QueryPayOrder',
        'create-order'        => 'CreateOrder',
        'submit-utr'          => 'SubmitUtr',
        //1
        'count-collect-order' => 'CountCollectOrder',
        'count-pay-order'     => 'CountPayOrder',
    ];

    public const COMMAND_SET_CN = [
        '开始'         => 'cnStart',
        '帮助'         => 'cnHelp',
        '获取ID'       => 'cnGetId',
        '获取群ID'     => 'cnGetGroupId',
        '绑定'         => 'cnBind',
        '查询'         => 'cnQuery',
        '查询订单'     => 'cnOrder',
        '查询收款订单' => 'cnQueryCollectOrder',
        '查询付款订单' => 'cnQueryPayOrder',
        '创建付款订单' => 'cnCreateOrder',
        '提交UTR补单'  => 'SubmitUtr',
        '统计收款订单' => 'cnCountCollectOrder',
        '统计付款订单' => 'cnCountPayOrder',
    ];


    // 是否是命令
    public static function isCommand(string $command): bool
    {
        return in_array($command, self::COMMAND_SET_CN) || in_array($command, self::COMMAND_SET);
    }

    public static function getCommand(string $command): string
    {
        if (in_array($command, self::COMMAND_SET_CN)) {
            return self::COMMAND_SET_CN[$command];
        }
        if (in_array($command, self::COMMAND_SET)) {
            return self::COMMAND_SET[$command];
        }
        return '';
    }
}
