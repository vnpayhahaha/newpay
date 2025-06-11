<?php

use app\service\upload\storage\Cos;
use app\service\upload\storage\Local;
use app\service\upload\storage\Oss;
use app\service\upload\storage\Qiniu;
use app\service\upload\storage\S3;

return [
    'debug'           => config('app.debug'),
    'config_key'      => [
        'local' => '',
        'oss'   => '',
        'cos'   => '',
        'qiniu' => '',
        's3'    => '',
    ],
    'adapter_classes' => [
        'local' => Local::class,
        'oss'   => Oss::class,
        'cos'   => Cos::class,
        'qiniu' => Qiniu::class,
        's3'    => S3::class,
    ],
];
