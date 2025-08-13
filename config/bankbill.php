<?php

use app\constants\DisbursementOrder;

return [
    DisbursementOrder::BILL_TEMPLATE_ICICI        => [
        'down_filename' =>  'order_icicicorporate_bank_card_no_' .date('YmdHis'),
        'down_filepath' => '/public/download/bill/icici/',
        'upload_example_file' => '/templates/ICICI导入订单格式.xlsx',
        'upload_filepath' => '/public/upload/bill/icici/',
        'down_dto_class' => \app\service\bankbill\down\DtoBillOfICICI::class,
        'down_sheetIndex' => 0,
    ],
    DisbursementOrder::BILL_TEMPLATE_ICICI2       => [

    ],
];