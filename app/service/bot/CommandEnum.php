<?php

namespace app\service\bot;

class CommandEnum
{

    public const TELEGRAM_COMMAND_RUN_QUEUE_NAME = 'telegram-command-run-queue';
    public const TELEGRAM_NOTICE_QUEUE_NAME = 'telegram-notice-queue';
    // 定义中文指令集
    public const COMMAND_SET = [
        'help'                => 'Help',
        'get_id'              => 'GetId',
        'get_group_id'        => 'GetGroupId',
        'bind'                => 'Bind',
        'query'               => 'Query',
        'order'               => 'Order',
        'query_collect_order' => 'QueryCollectOrder',
        'query_pay_order'     => 'QueryPayOrder',
        'create_pay_order'    => 'CreatePayOrder',
        'submit_utr'          => 'SubmitUtr',
        'count_collect_order' => 'CountCollectOrder',
        'count_pay_order'     => 'CountPayOrder',
    ];

    public static array $commandDescMap = [
        'help'                => "<blockquote>[Eg]/help</blockquote>",
        'get_id'              => "<blockquote>[Eg]/get-id</blockquote>",
        'get_group_id'        => "<blockquote>[Eg]/get-group-id</blockquote>",
        'bind'                => "<blockquote>[Eg]/bind 000001" . PHP_EOL . "/Param/tenant_id !Merchant ID</blockquote>",
        'query'               => "<blockquote>[Eg]/query</blockquote>",
        'order'               => "<blockquote>[Eg]/order CO20250723234556781156197C9" . PHP_EOL . "/Param/platform_order_no !Platform Order Number</blockquote>",
        'query_collect_order' => "<blockquote>[Eg]/query-collect-order 123456" . PHP_EOL . "/Param/tenant_order_no !Merchant Order Number</blockquote>",
        'query_pay_order'     => "<blockquote>[Eg]/query-pay-order 654321" . PHP_EOL . "/Param/tenant_order_no !Merchant Order Number</blockquote>",
        'create_pay_order'    => 'CreatePayOrder',
        'submit_utr'          => "<blockquote>[Eg]/submit-utr CO20250723234556781156197C9 432219999747" . PHP_EOL . "/Param/platform_order_no !Platform Order Number" . PHP_EOL . "/Param/utr !UTR credentials</blockquote>",
        'count_collect_order' => 'CountCollectOrder',
        'count_pay_order'     => 'CountPayOrder',
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
        '创建付款订单' => 'cnCreatePayOrder',
        '提交UTR补单'  => 'SubmitUtr',
        '统计收款订单' => 'cnCountCollectOrder',
        '统计付款订单' => 'cnCountPayOrder',
    ];
    public static array $commandDescCnMap = [
        '帮助'         => "<blockquote>[示例]/帮助</blockquote>",
        '获取ID'       => "<blockquote>[示例]/获取ID</blockquote>",
        '获取群ID'     => "<blockquote>[示例]/获取群ID</blockquote>",
        '绑定'         => "<blockquote>[示例]/绑定 000001" . PHP_EOL . "/参数/tenant_id !商户ID</blockquote>",
        '查询'         => "<blockquote>[示例]/查询</blockquote>",
        '查询订单'     => "<blockquote>[示例]/查询订单 CO20250723234556781156197C9" . PHP_EOL . "/参数/platform_order_no !平台订单号</blockquote>",
        '查询收款订单' => "<blockquote>[示例]/查询收款订单 123456" . PHP_EOL . "/参数/tenant_order_no !商户订单号</blockquote>",
        '查询付款订单' => "<blockquote>[示例]/查询付款订单 654321" . PHP_EOL . "/参数/tenant_order_no !商户订单号</blockquote>",
        '创建付款订单' => 'cnCreatePayOrder',
        '提交UTR补单'  => "<blockquote>[示例]/提交UTR补单 CO20250723234556781156197C9 432219999747" . PHP_EOL . "/参数/platform_order_no !平台订单号" . PHP_EOL . "/参数/utr !UTR凭证</blockquote>",
        '统计收款订单' => 'cnCountCollectOrder',
        '统计付款订单' => 'cnCountPayOrder',
    ];

    // 是否是命令
    public static function isCommand(string $command): bool
    {
        $command_set_cn_keys = array_keys(self::COMMAND_SET_CN);
        $command_set_keys = array_keys(self::COMMAND_SET);
        return in_array($command, $command_set_cn_keys, true) || in_array(strtolower(trim($command)), $command_set_keys, true);
    }

    public static function getCommand(string $command): string
    {
        $command_set_cn_keys = array_keys(self::COMMAND_SET_CN);
        if (in_array($command, $command_set_cn_keys, true)) {
            return self::COMMAND_SET_CN[$command];
        }
        $command_set_keys = array_keys(self::COMMAND_SET);
        if (in_array(strtolower($command), $command_set_keys, true)) {
            return self::COMMAND_SET[$command];
        }
        return '';
    }

    public static function getHelpReply(bool $isCn = false): array
    {
        $reply = [];
        if ($isCn) {
            $reply[] = '***** 命令列表 *****';
            $keys = array_keys(self::COMMAND_SET_CN);
            foreach ($keys as $key) {
                $reply[] = '/' . $key;
                $reply[] = self::$commandDescCnMap[$key];
            }
        } else {
            $reply[] = '***** Command List *****';
            $keys = array_keys(self::COMMAND_SET);
            foreach ($keys as $key) {
                $reply[] = '/' . $key;
                $reply[] = self::$commandDescMap[$key];
            }
        }
        return $reply;
    }
}
