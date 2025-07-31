<?php

return [
    'enums' => [
        'status'          => [
            // 0-创建 10-处理中 20-成功 30-挂起 40-失败 41-已取消 43-已失效 44-已退款
            0  => '创建',
            10 => '处理中',
            20 => '成功',
            30 => '挂起',
            40 => '失败',
            41 => '已取消',
            43 => '已失效',
            44 => '已退款',
        ],
        'collection_type' => [
            'bank_account' => '银行卡',
            'upi'          => 'UPI',
            'upstream'     => '上游',
        ],
        'settlement_type' => [
            'not_settled'  => '未入账',
            'paid_amount'  => '实付金额',
            'order_amount' => '订单金额',
        ],
    ],
];
