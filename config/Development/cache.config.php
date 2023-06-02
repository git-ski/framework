<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'cache' => [
        'default' => 'redis',
        'adapter' => [
            'redis' => [
                'adapter' => [
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
                ]
            ],
            'memory' => [
                'adapter' => [
                    'name' => 'memory',
                    'options' => [
                        'namespace' => null,
                    ],
                ]
            ],
        ]
    ],
];
