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
            'order_id' => 'Order Id',
            'order_no' => 'Order No',
            'utr'      => 'UTR',
            'amount'   => 'Amount',
        ],
        'transaction_type'         => [
            'collection' => '代收',
            'payment'    => '代付',
        ],
    ]
];
