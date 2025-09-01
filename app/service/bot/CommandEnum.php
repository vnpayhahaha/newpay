<?php

namespace app\service\bot;

class CommandEnum
{

    public const TELEGRAM_COMMAND_RUN_QUEUE_NAME = 'telegram-command-run-queue';
    public const TELEGRAM_NOTICE_QUEUE_NAME = 'telegram-notice-queue';
    // 定义中文指令集
    public const COMMAND_SET = [
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

    public static array $commandDescMap = [
        'help'                => "<blockquote>Note: Please use parameter separators [@, spaces, line breaks]</blockquote>",
        'get-id'              => "<blockquote>[Eg]/get-id</blockquote>",
        'get-group-id'        => "<blockquote>[Eg]/get-group-id</blockquote>",
        'bind'                => "<blockquote>[Eg]/bind 000001" . PHP_EOL . "/Param/tenant_id !Merchant ID</blockquote>",
        'query'               => "<blockquote>[Eg]/query</blockquote>",
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
    public static array $commandDescCnMap = [
        '帮助'         => "<blockquote>注意：请统一使用参数分隔符【@ 空格 换行】</blockquote>",
        '获取ID'       => "<blockquote>[示例]/获取ID</blockquote>",
        '获取群ID'     => "<blockquote>[示例]/获取群ID</blockquote>",
        '绑定'         => "<blockquote>[示例]/绑定 000001" . PHP_EOL . "/参数/tenant_id !商户ID</blockquote>",
        '查询'         => "<blockquote>[示例]/查询</blockquote>",
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
        if (in_array(strtolower($command), self::COMMAND_SET)) {
            return self::COMMAND_SET[$command];
        }
        return '';
    }

    public static function getHelpReply(bool $isCn = false): array
    {
        $reply = [];
        if($isCn){
            $reply[] = '*命令列表*';
            $keys = array_keys(self::COMMAND_SET_CN);
            foreach ($keys as $key) {
                $reply[] = '/' . $key;
                $reply[] = self::$commandDescCnMap[$key];
            }
        }else{
            $reply[] = '*Command List*';
            $keys = array_keys(self::COMMAND_SET);
            foreach ($keys as $key) {
                $reply[] = '/' . $key;
                $reply[] = self::$commandDescMap[$key];
            }
        }
        return $reply;
    }
}
