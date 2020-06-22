<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'translation' => [
        'language' => [
            'storageAdapter' => [
                'name' => 'redis',
                'options' => [
                    'name' => 'memory',
                    'options' => [
                        'namespace' => null,
                    ],
                    // 'server' => [
                    //     'host' => 'redis_server',
                    //     'port' => 6379,
                    //     'timeout' => 5,
                    // ],
                    // 'namespace' => 'lang'
                ],
            ],
        ],
    ]
];
