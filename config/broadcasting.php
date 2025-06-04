<?php

return [
    'default' => env('BROADCAST_DRIVER', 'redis'),

    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
        ],
    ],
]; 