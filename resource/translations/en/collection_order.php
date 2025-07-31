<?php

return [
    'enums' => [
        'status'          => [
            0  => 'Created',
            10 => 'Processing',
            20 => 'Success',
            30 => 'Suspended',
            40 => 'Failed',
            41 => 'Cancelled',
            43 => 'Invalid',
            44 => 'Refunded',
        ],
        'collection_type' => [
            'bank_account' => 'Bank Account',
            'upi'          => 'UPI',
            'upstream'     => 'Upstream',
        ],
        'settlement_type' => [
            'not_settled'  => 'Not Settled',
            'paid_amount'  => 'Paid Amount',
            'order_amount' => 'Order Amount',
        ],
    ],
];
