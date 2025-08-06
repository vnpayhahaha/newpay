<?php

return [
    'enums' => [
        'status'        => [
            // 0-创建 10-待支付 11-待回填 20-成功 30-挂起 \r\n    40-失败 41-已取消 43-已失效 44-已退款
            0  => '创建',
            10 => '待支付',
            11 => '待回填',
            20 => '成功',
            30 => '挂起',
            40 => '失败',
            41 => '已取消',
            43 => '已失效',
            44 => '已退款',
        ],
        'notify_status' => [
            'not_notify'     => '未通知',
            'notify_success' => '已通知',
            'notify_fail'    => '通知失败',
            'callback_ing'   => '回调中',
        ],
        'payment_type'  => [
            'bank_card' => '银行卡',
            'upi'       => 'UPI',
        ],
        'channel_type'  => [
            'bank'     => '银行',
            'upstream' => '上游',
        ],
    ],
];
