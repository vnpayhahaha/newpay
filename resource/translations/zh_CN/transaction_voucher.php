<?php

return [
    'enums' => [
        'collection_status'        => [
            'waiting'    => '等待结算',
            'processing' => '处理中',
            'cancel'     => '撤销',
            'success'    => '成功',
            'fail'       => '失败',
        ],
        'collection_source'        => [
            'undefined' => '未定义',
            'manual'    => '人工创建',
            'internal'  => '平台内部接口',
            'open_api'  => '平台开放下游接口',
            'external'  => '上游回调接口',
        ],
        'transaction_voucher_type' => [
            'order_no' => '订单号',
            'utr'      => 'UTR',
            'amount'   => '金额',
        ],
        'transaction_type'         => [
            'collection' => '代收',
            'payment'    => '代付',
        ],
    ]
];
