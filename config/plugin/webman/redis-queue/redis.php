<?php
return [
    'default' => [
        'host'    => 'redis://' . env('REDIS_HOST', 'localhost') . ':' . env('REDIS_PORT', 6379),
        'options' => [
            'auth'          => env('REDIS_AUTH', null),
            'db'            => env('REDIS_QUEUE_DB', 1),
            'prefix'        => env('APP_NAME', ''),
            'max_attempts'  => 5,
            'retry_seconds' => 10,
        ],
        // Connection pool, supports only Swoole or Swow drivers.
        'pool'    => [
            'max_connections'    => 5,
            'min_connections'    => 1,
            'wait_timeout'       => 3,
            'idle_timeout'       => 60,
            'heartbeat_interval' => 50,
        ]
    ],
];
