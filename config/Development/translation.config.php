<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'translation' => [
        'language' => [
            'storageAdapter' => [
                'name' => 'redis',
                'options' => [
                    'server' => [
                        'host' => 'cache',
                        'port' => 6379,
                    ],
                    'ttl' => 3600,
                    'namespace' => null,
                    'lib_options' => [
                        // \Redis::OPT_SERIALIZER => \Redis::SERIALIZER_PHP,
                    ],
                ],
        ],
        ],
    ]
];
