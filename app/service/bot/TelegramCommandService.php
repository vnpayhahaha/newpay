<?php

namespace app\service\bot;

use app\constants\CollectionOrder;
use app\constants\TenantAccount;
use app\constants\TransactionVoucher;
use app\repository\TenantRepository;
use app\repository\TransactionVoucherRepository;
use app\service\CollectionOrderService;
use app\service\DisbursementOrderService;
use DI\Attribute\Inject;
use support\Log;
use Telegram as TelegramBot;

class TelegramCommandService
{
    public TelegramBot $telegramBot;

    #[Inject]
    protected TenantRepository $tenantRepository;

    #[Inject]
    protected CollectionOrderService $collectionOrderService;

    #[Inject]
    protected DisbursementOrderService $disbursementOrderService;

    #[Inject]
    protected TransactionVoucherRepository $transactionVoucherRepository;


    public function setTelegramBot(TelegramBot $telegramBot): static
    {
        $this->telegramBot = $telegramBot;
        return $this;
    }

    private function getTenant(): ?\app\model\ModelTenant
    {
        $chatID = $this->telegramBot->ChatID();
        return $this->tenantRepository->getTenantByTgChatId($chatID);
    }

    /**获取文件的下载地址
     * @param $file_id
     * @return array
     */
    protected function getFileUrl($file_id): array
    {
        $rs = $this->telegramBot->getFile($file_id);

        if (isset($rs['ok'], $rs['result']['file_path']) && $rs['ok'] === true) {

            $token = env('TELEGRAM_TOKEN');
            $a['file_path'] = $rs['result']['file_path'];
            $a['url'] = sprintf("https://api.telegram.org/file/bot%s/%s", $token, $rs['result']['file_path']);
            return $a;
        }
        return [];
    }

    // 图片补单（发送图片自动识别，并且图片下面的说明就是订单编号）
    public function writeOffOrderByPhoto(): string|array
    {
        $order_no = $this->telegramBot->Caption();
        if (!$order_no) {
            return [
                'Please enter the platform order number below the picture',
                '请在图片下方输入平台订单编号'
            ];
        }
        $file_id = $this->telegramBot->PhotoFileId();
        if (!$file_id) {
            return [
                'Image acquisition failed! Please resend the picture',
                '图片获取失败！请重新发送图片'
            ];
        }
        $pic_url_arr = $this->getFileUrl($file_id);
        if (empty($pic_url_arr)) {
            return [
                'Image acquisition failed! Please resend the picture',
                '图片获取失败！请重新发送图片'
            ];
        }
        Log::info('writeOffOrderByPhoto :', $pic_url_arr);
        $getPicWordData = get_ocr_words($pic_url_arr['url']);

        if ($getPicWordData['ok'] === false) {
            return [
                'Image parsing failed! Please resend the picture',
                '图片解析失败！请重新发送图片',
                $getPicWordData['data']
            ];
        }
        // 正则表达式：匹配连续12位数字且后面不是@字符
        preg_match('/(?<!\d)\d{12}(?!\@)(?!\d)/', $getPicWordData['data'], $matches);

        // $matches[0] 将包含第一个匹配的字符串
        $utr = $matches[0] ?? '';

        if ($utr === '') {
            return [
                'The image parsing failed and the UTR was not parsed',
                '图片解析失败,没有解析到UTR',
                $getPicWordData['data']
            ];
        }
        $user_id = $this->telegramBot->UserId();
        Log::info('TelegramBot OCR 补单核销', [
            $user_id,
            $order_no,
            $utr,
            json_encode($getPicWordData, JSON_THROW_ON_ERROR)
        ]);
        return $this->SubmitUtr($user_id, [
            $order_no,
            $utr
        ], 0);
    }

    public function SubmitUtr(int $UID, array $params, int $recordID): string|array
    {
        if (count($params) !== 2) {
            return [
                'Parameter error: Please enter the platform order number and UTR',
                '参数错误: 请输入平台订单编号和UTR'
            ];
        }
        [
            $order_no,
            $utr
        ] = $params;
        if (!$order_no || !$utr) {
            return [
                'Parameter error: Platform order number and UTR cannot be empty',
                '参数错误: 平台订单编号和UTR不能为空'
            ];
        }
        if (!$this->getTenant()) {
            return [
                'You have not bound a merchant yet, please bind the merchant first and submit a UTR supplementary order',
                '您还未绑定商户，请先绑定商户再提交UTR补单'
            ];
        }
        // 查询收款订单
        $collectionOrder = $this->collectionOrderService->repository->getQuery()
            ->where('utr', $utr)
            ->orWhere('customer_submitted_utr', $utr)
            ->first();

        if ($collectionOrder) {
            $orderStatusMsg = CollectionOrder::getHumanizeValueDouble(CollectionOrder::$status_list, $collectionOrder->status);
            if ($collectionOrder->platform_order_no === $order_no) {
                // 订单状态 已完成
                if ($collectionOrder->status === CollectionOrder::STATUS_SUCCESS) {
                    return [
                        'The order has been completed',
                        '订单已完成',
                        '------------------------',
                        'Platform Order Number：[平台订单号]',
                        $collectionOrder->platform_order_no,
                        'Merchant Order Number：[商户订单号]',
                        $collectionOrder->tenant_order_no,
                        'UTR credentials：[UTR凭证]',
                        $collectionOrder->utr,
                        'Order Status：[订单状态]',
                        $orderStatusMsg['en'] . '[' . $orderStatusMsg['zh'] . ']',
                        'Order amount：[订单金额]',
                        $collectionOrder->amount,
                        'Payment time：[支付时间]',
                        $collectionOrder->pay_time,
                    ];
                }

                if ($collectionOrder->customer_submitted_utr === $utr) {
                    return [
                        'UTR credentials have been recorded, please do not submit them repeatedly',
                        'UTR凭证已记录，请勿重复提交',
                        '------------------------',
                        'Platform Order Number：[平台订单号]',
                        $collectionOrder->platform_order_no,
                        'Merchant Order Number：[商户订单号]',
                        $collectionOrder->tenant_order_no,
                        'UTR credentials：[UTR凭证]',
                        $collectionOrder->utr,
                        'Submitted UTR credentials：[提交的UTR凭证]',
                        $collectionOrder->customer_submitted_utr,
                        'Order Status：[订单状态]',
                        $orderStatusMsg['en'] . '[' . $orderStatusMsg['zh'] . ']',
                        'Order amount：[订单金额]',
                        $collectionOrder->amount,
                    ];
                }
            } else {
                return [
                    'UTR vouchers have been recorded, the platform order number does not match',
                    'UTR凭证已被记录，平台订单号不匹配',
                    '------------------------',
                    'Platform Order Number：[平台订单号]',
                    $collectionOrder->platform_order_no,
                    'Merchant Order Number：[商户订单号]',
                    $collectionOrder->tenant_order_no,
                    'UTR credentials：[UTR凭证]',
                    $collectionOrder->utr,
                    'Submitted UTR credentials：[提交的UTR凭证]',
                    $collectionOrder->customer_submitted_utr,
                    'Order Status：[订单状态]',
                    $orderStatusMsg['en'] . '[' . $orderStatusMsg['zh'] . ']',
                    'Order amount：[订单金额]',
                    $collectionOrder->amount,
                ];
            }

        }
        $collectionOrder = $this->collectionOrderService->repository->getQuery()
            ->where('platform_order_no', $order_no)
            ->first();
        if (!$collectionOrder) {
            return [
                $order_no,
                'The platform order number does not exist',
                '平台订单号不存在'
            ];
        }
        $orderStatusMsg = CollectionOrder::getHumanizeValueDouble(CollectionOrder::$status_list, $collectionOrder->status);
        // 查询收款凭证
        $transactionVoucher = $this->transactionVoucherRepository->getQuery()
            ->where('transaction_voucher_type', TransactionVoucher::TRANSACTION_VOUCHER_TYPE_UTR)
            ->where('transaction_type', TransactionVoucher::TRANSACTION_TYPE_COLLECTION)
            ->where('transaction_voucher', $utr)
            ->first();
        if (!$transactionVoucher) {
            // 存储utr凭证到订单
            $collectionOrder->submitted_utr = $utr;
            if ($collectionOrder->save()) {
                return [
                    'UTR credentials have been recorded, please wait for the system to process',
                    'UTR凭证已记录,请等待系统处理',
                    '------------------------',
                    'Platform Order Number：[平台订单号]',
                    $collectionOrder->platform_order_no,
                    'Merchant Order Number：[商户订单号]',
                    $collectionOrder->tenant_order_no,
                    'UTR credentials：[UTR凭证]',
                    $utr,
                    'Submitted UTR credentials：[提交的UTR凭证]',
                    $collectionOrder->customer_submitted_utr,
                    'Order Status：[订单状态]',
                    $orderStatusMsg['en'] . '[' . $orderStatusMsg['zh'] . ']',
                    'Order amount：[订单金额]',
                    $collectionOrder->amount,
                ];
            }
            return [
                'Failed to record UTR credentials',
                'UTR凭证记录失败',
                '------------------------',
                'Platform Order Number：[平台订单号]',
                $collectionOrder->platform_order_no,
                'Merchant Order Number：[商户订单号]',
                $collectionOrder->tenant_order_no,
                'UTR credentials：[UTR凭证]',
                $utr,
                'Submitted UTR credentials：[提交的UTR凭证]',
                $collectionOrder->customer_submitted_utr,
                'Order Status：[订单状态]',
                $orderStatusMsg['en'] . '[' . $orderStatusMsg['zh'] . ']',
                'Order amount：[订单金额]',
                $collectionOrder->amount,
            ];
        }

        if ($transactionVoucher->collection_status === TransactionVoucher::COLLECTION_STATUS_SUCCESS) {
            return [
                'UTR credentials have been written off and cannot be used again',
                'UTR凭证已被核销，无法再次使用',
                '------------------------',
                'Platform Order Number：[平台订单号]',
                $transactionVoucher->order_no,
                'UTR credentials：[UTR凭证]',
                $utr,
                'Payment amount：[收款金额]',
                $transactionVoucher->collection_amount,
                'Collection time：[收款时间]',
                $transactionVoucher->collection_time,
            ];
        }
        if ($transactionVoucher->collection_status >= TransactionVoucher::COLLECTION_STATUS_FAIL) {
            return [
                'UTR credential status is abnormal, please contact customer service to handle it',
                'UTR凭证状态异常，请联系客服处理',
                '------------------------',
                'Platform Order Number：[平台订单号]',
                $transactionVoucher->order_no,
                'UTR credentials：[UTR凭证]',
                $utr,
                'Payment amount：[收款金额]',
                $transactionVoucher->collection_amount,
                'Collection time：[收款时间]',
                $transactionVoucher->collection_time,
            ];
        }

        $isOk = $this->collectionOrderService->writeOff($collectionOrder->id, $transactionVoucher->id);
        if ($isOk) {
            return [
                'UTR credentials have been written off successfully',
                'UTR凭证核销成功',
                '------------------------',
                'Platform Order Number：[平台订单号]',
                $collectionOrder->platform_order_no,
                'Merchant Order Number：[商户订单号]',
                $collectionOrder->tenant_order_no,
                'UTR credentials：[UTR凭证]',
                $utr,
                'Submitted UTR credentials：[提交的UTR凭证]',
                $collectionOrder->customer_submitted_utr,
                'Order Status：[订单状态]',
                $orderStatusMsg['en'] . '[' . $orderStatusMsg['zh'] . ']',
                'Order amount：[订单金额]',
            ];
        }
        return [
            'UTR credentials have been written off failed',
            'UTR凭证核销失败',
            '------------------------',
            'Platform Order Number：[平台订单号]',
            $collectionOrder->platform_order_no,
            'Merchant Order Number：[商户订单号]',
            $collectionOrder->tenant_order_no,
            'UTR credentials：[UTR凭证]',
            $utr,
            'Submitted UTR credentials：[提交的UTR凭证]',
            $collectionOrder->customer_submitted_utr,
        ];
    }


    // ===================================================================================================================

    public function Help(int $uid, array $params, int $recordID): string|array
    {
        $reply = [
            'Welcome to this system',
        ];
        $commandArr = CommandEnum::getHelpReply();
        return array_merge($reply, $commandArr);
    }

    public function cnHelp(int $uid, array $params, int $recordID): string|array
    {
        $reply = [
            '欢迎使用本系统',
        ];
        $commandArr = CommandEnum::getHelpReply(true);
        return array_merge($reply, $commandArr);
    }

    public function GetId(int $uid, array $params, int $recordID): string|array
    {
        return [
            'Your chat ID is:' . $this->telegramBot->ChatID(),
        ];
    }

    public function cnGetId(int $uid, array $params, int $recordID): string|array
    {
        return [
            '你的聊天ID是:' . $this->telegramBot->ChatID(),
        ];
    }

    public function GetGroupId(int $uid, array $params, int $recordID): string|array
    {
        return [
            'Your group ID is:' . $this->telegramBot->ChatID(),
        ];
    }

    public function cnGetGroupId(int $uid, array $params, int $recordID): string|array
    {
        return [
            '你的群组ID是:' . $this->telegramBot->ChatID(),
        ];
    }

    public function Bind(int $uid, array $params, int $recordID): string|array
    {
        if (!filled($params)) {
            return [
                'Please enter the merchant number',
            ];
        }
        $param_tenant_id = $params[0];
        $tenant = $this->tenantRepository->getTenantByTenantId($param_tenant_id);
        if (!$tenant) {
            return [
                'Please enter the correct merchant number to bind',
            ];
        }
        $chatIdTenant = $this->getTenant();
        if ($chatIdTenant) {
            if ($chatIdTenant->tenant_id === $tenant->tenant_id) {
                return [
                    'This merchant has been bound to this chat',
                ];
            }
            $chatIdTenant->tenant_id = $param_tenant_id;
            if (!$chatIdTenant->save()) {
                return [
                    'Binding failed',
                ];
            }
        }
        $tenant->tg_chat_id = $this->telegramBot->ChatID();
        if (!$tenant->save()) {
            return [
                'Binding failed',
            ];
        }
        return [
            'Binding successful',
        ];
    }

    public function cnBind(int $uid, array $params, int $recordID): string|array
    {
        if (!filled($params)) {
            return [
                '请输入商户号',
            ];
        }
        $param_tenant_id = $params[0];
        $tenant = $this->tenantRepository->getTenantByTenantId($param_tenant_id);
        if (!$tenant) {
            return [
                '请输入正确的商户号进行绑定',
            ];
        }
        $chatIdTenant = $this->getTenant();
        if ($chatIdTenant) {
            if ($chatIdTenant->tenant_id === $tenant->tenant_id) {
                return [
                    '此商户已绑定此群聊',
                ];
            }
            $chatIdTenant->tenant_id = $param_tenant_id;
            if (!$chatIdTenant->save()) {
                return [
                    '绑定失败',
                ];
            }
        }
        $tenant->tg_chat_id = $this->telegramBot->ChatID();
        if (!$tenant->save()) {
            return [
                '绑定失败',
            ];
        }
        return [
            '绑定成功',
        ];
    }

    public function Query(int $uid, array $params, int $recordID): string|array
    {
        $chatIdTenant = $this->getTenant();
        if (!$chatIdTenant) {
            return [
                'Please bind the merchant first',
            ];
        }
        $collectionBalance = '0.00';
        $collectionBalanceFrozen = '0.00';
        $disbursementBalance = '0.00';
        $disbursementBalanceFrozen = '0.00';
        if (isset($chatIdTenant['accounts']) && filled($chatIdTenant['accounts'])) {
            foreach ($chatIdTenant['accounts'] as $account) {
                if ($account['account_type'] === TenantAccount::ACCOUNT_TYPE_RECEIVE) {
                    $collectionBalance = $account['balance_available'];
                    $collectionBalanceFrozen = $account['balance_frozen'];
                } elseif ($account['account_type'] === TenantAccount::ACCOUNT_TYPE_PAY) {
                    $disbursementBalance = $account['balance_available'];
                    $disbursementBalanceFrozen = $account['balance_frozen'];
                }
            }
        }
        return [
            'Merchant number：',
            $chatIdTenant->tenant_id,
            'Merchant name：',
            $chatIdTenant->company_name,
            'Merchant status：',
            $chatIdTenant->is_enabled,
            '------------------------',
            'Available balance for collection: ',
            $collectionBalance,
            'Freeze amount of collection：',
            $collectionBalanceFrozen,
            'Available balance for disbursement：',
            $disbursementBalance,
            'Freeze amount of disbursement：',
            $disbursementBalanceFrozen,
        ];
    }

    public function cnQuery(int $uid, array $params, int $recordID): string|array
    {
        $chatIdTenant = $this->getTenant();
        if (!$chatIdTenant) {
            return [
                '请先绑定商户',
            ];
        }
        $collectionBalance = '0.00';
        $collectionBalanceFrozen = '0.00';
        $disbursementBalance = '0.00';
        $disbursementBalanceFrozen = '0.00';
        if (isset($chatIdTenant['accounts']) && filled($chatIdTenant['accounts'])) {
            foreach ($chatIdTenant['accounts'] as $account) {
                if ($account['account_type'] === TenantAccount::ACCOUNT_TYPE_RECEIVE) {
                    $collectionBalance = $account['balance_available'];
                    $collectionBalanceFrozen = $account['balance_frozen'];
                } elseif ($account['account_type'] === TenantAccount::ACCOUNT_TYPE_PAY) {
                    $disbursementBalance = $account['balance_available'];
                    $disbursementBalanceFrozen = $account['balance_frozen'];
                }
            }
        }
        return [
            '[商户号]',
            $chatIdTenant->tenant_id,
            '[商户名称]',
            $chatIdTenant->company_name,
            '[商户状态]',
            $chatIdTenant->is_enabled,
            '------------------------',
            '[收款可用余额]',
            $collectionBalance,
            '[收款冻结金额]',
            $collectionBalanceFrozen,
            '[付款可用余额]',
            $disbursementBalance,
            '[付款冻结金额]',
            $disbursementBalanceFrozen,
        ];
    }

    public function Order(int $uid, array $params, int $recordID): string|array
    {
        $chatIdTenant = $this->getTenant();
        if (!$chatIdTenant) {
            return [
                'Please bind the merchant first',
            ];
        }
        $platform_order_no = $params[0];
        // 判断订单号 platform_order_no CO开头是收款订单 DO开头是付款订单 否则错误
        if (str_starts_with($platform_order_no, 'CO')) {
            $order = $this->collectionOrderService->repository->getQuery()->where('platform_order_no', $platform_order_no)->first();
            if (!$order) {
                return [
                    'Collection order does not exist',
                ];
            }
            $orderStatusMsg = CollectionOrder::getHumanizeValueDouble(CollectionOrder::$status_list, $order->status);
        } elseif (str_starts_with($platform_order_no, 'DO')) {
            $order = $this->disbursementOrderService->repository->getQuery()->where('platform_order_no', $platform_order_no)->first();
            if (!$order) {
                return [
                    'Disbursement order does not exist',
                ];
            }
            $orderStatusMsg = CollectionOrder::getHumanizeValueDouble(CollectionOrder::$status_list, $order->status);
        } else {
            return [
                'Invalid order number',
            ];
        }

        return [
            '------------------------',
            'Platform Order Number：',
            $order->platform_order_no,
            'Merchant Order Number：',
            $order->tenant_order_no,
            'UTR credentials：',
            $order->utr,
            'Order Status：',
            $orderStatusMsg['en'],
            'Order amount：',
            $order->amount,
            'Paid time：',
            $order->pay_time,
        ];
    }

    public function cnOrder(int $uid, array $params, int $recordID): string|array
    {
        $chatIdTenant = $this->getTenant();
        if (!$chatIdTenant) {
            return [
                '请先绑定商户',
            ];
        }
        $platform_order_no = $params[0];
        // 判断订单号 platform_order_no CO开头是收款订单 DO开头是付款订单 否则错误
        if (str_starts_with($platform_order_no, 'CO')) {
            $order = $this->collectionOrderService->repository->getQuery()->where('platform_order_no', $platform_order_no)->first();
            if (!$order) {
                return [
                    '收款订单不存在',
                ];
            }
            $orderStatusMsg = CollectionOrder::getHumanizeValueDouble(CollectionOrder::$status_list, $order->status);
        } elseif (str_starts_with($platform_order_no, 'DO')) {
            $order = $this->disbursementOrderService->repository->getQuery()->where('platform_order_no', $platform_order_no)->first();
            if (!$order) {
                return [
                    '付款订单不存在',
                ];
            }
            $orderStatusMsg = CollectionOrder::getHumanizeValueDouble(CollectionOrder::$status_list, $order->status);
        } else {
            return [
                '无效的订单号',
            ];
        }
        return [
            '------------------------',
            '平台订单号：',
            $order->platform_order_no,
            '商户订单号：',
            $order->tenant_order_no,
            'UTR凭证：',
            $order->utr,
            '订单状态：',
            $orderStatusMsg['zh'],
            '订单金额：',
            $order->amount,
            '付款时间：',
            $order->pay_time,
        ];
    }

    public function QueryCollectOrder(int $uid, array $params, int $recordID): string|array
    {
        $chatIdTenant = $this->getTenant();
        if (!$chatIdTenant) {
            return [
                'Please bind the merchant first',
            ];
        }
        $tenant_order_no = $params[0];
        $order = $this->collectionOrderService->repository->getQuery()->where('tenant_order_no', $tenant_order_no)->first();
        if (!$order) {
            return [
                'Collection order does not exist',
            ];
        }
        $orderStatusMsg = CollectionOrder::getHumanizeValueDouble(CollectionOrder::$status_list, $order->status);
        return [
            '------------------------',
            'Platform Order Number：',
            $order->platform_order_no,
            'Merchant Order Number：',
            $order->tenant_order_no,
            'UTR credentials：',
            $order->utr,
            'Order Status：',
            $orderStatusMsg['en'],
            'Order amount：',
            $order->amount,
            'Paid time：',
            $order->pay_time,
        ];
    }

    public function cnQueryCollectOrder(int $uid, array $params, int $recordID): string|array
    {
        $chatIdTenant = $this->getTenant();
        if (!$chatIdTenant) {
            return [
                '请先绑定商户',
            ];
        }
        $tenant_order_no = $params[0];
        $order = $this->collectionOrderService->repository->getQuery()->where('tenant_order_no', $tenant_order_no)->first();
        if (!$order) {
            return [
                '收款订单不存在',
            ];
        }
        $orderStatusMsg = CollectionOrder::getHumanizeValueDouble(CollectionOrder::$status_list, $order->status);
        return [
            '------------------------',
            '平台订单号：',
            $order->platform_order_no,
            '商户订单号：',
            $order->tenant_order_no,
            'UTR凭证：',
            $order->utr,
            '订单状态：',
            $orderStatusMsg['zh'],
            '订单金额：',
            $order->amount,
            '付款时间：',
            $order->pay_time,
        ];
    }

    public function QueryPayOrder(int $uid, array $params, int $recordID): string|array
    {
        $chatIdTenant = $this->getTenant();
        if (!$chatIdTenant) {
            return [
                'Please bind the merchant first',
            ];
        }
        $tenant_order_no = $params[0];
        $order = $this->disbursementOrderService->repository->getQuery()->where('tenant_order_no', $tenant_order_no)->first();
        if (!$order) {
            return [
                'Payment order does not exist',
            ];
        }
        $orderStatusMsg = CollectionOrder::getHumanizeValueDouble(CollectionOrder::$status_list, $order->status);
        return [
            '------------------------',
            'Platform Order Number：',
            $order->platform_order_no,
            'Merchant Order Number：',
            $order->tenant_order_no,
            'UTR credentials：',
            $order->utr,
            'Order Status：',
            $orderStatusMsg['en'],
            'Order amount：',
            $order->amount,
            'Paid time：',
            $order->pay_time,
        ];
    }

    public function cnQueryPayOrder(int $uid, array $params, int $recordID): string|array
    {
        $chatIdTenant = $this->getTenant();
        if (!$chatIdTenant) {
            return [
                '请先绑定商户',
            ];
        }
        $tenant_order_no = $params[0];
        $order = $this->disbursementOrderService->repository->getQuery()->where('tenant_order_no', $tenant_order_no)->first();
        if (!$order) {
            return [
                '付款订单不存在',
            ];
        }
        $orderStatusMsg = CollectionOrder::getHumanizeValueDouble(CollectionOrder::$status_list, $order->status);
        return [
            '------------------------',
            '平台订单号：',
            $order->platform_order_no,
            '商户订单号：',
            $order->tenant_order_no,
            'UTR凭证：',
            $order->utr,
            '订单状态：',
            $orderStatusMsg['zh'],
            '订单金额：',
            $order->amount,
            '付款时间：',
            $order->pay_time,
        ];
    }

}