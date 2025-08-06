<?php

return [
    'enums' => [
        'status'        => [
            // 0-创建 10-待支付 11-待回填 20-成功 30-挂起 \r\n    40-失败 41-已取消 43-已失效 44-已退款
            0  => 'Created',
            10 => 'Pending payment',
            11 => 'Processing',
            20 => 'Success',
            30 => 'Suspended',
            40 => 'Failed',
            41 => 'Cancelled',
            43 => 'Invalid',
            44 => 'Refunded',
        ],
        'notify_status' => [
            'not_notify'     => 'Not Notified',
            'notify_success' => 'Notify Success',
            'notify_fail'    => 'Notify Fail',
            'callback_ing'   => 'In the callback',
        ],
        'payment_type'  => [
            'bank_card' => 'Bank Card',
            'upi'       => 'UPI',
        ],
        'channel_type'  => [
            'bank'     => 'Bank',
            'upstream' => 'Upstream',
        ],
    ],
];
