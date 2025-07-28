<?php

return [
    'enums' => [
        'collection_status'        => [
            'waiting'    => 'waiting',
            'processing' => 'processing',
            'cancel'     => 'cancel',
            'success'    => 'success',
            'fail'       => 'fail',
        ],
        'collection_source'        => [
            'undefined' => 'unkown',
            'manual'    => 'manual',
            'internal'  => 'internal',
            'open_api'  => 'open_api',
            'external'  => 'external',
        ],
        'transaction_voucher_type' => [
            'order_no' => 'order_no',
            'utr'      => 'utr',
            'amount'   => 'amount',
        ],
        'transaction_type'         => [
            'collection' => '代收',
            'payment'    => '代付',
        ],
    ]
];
