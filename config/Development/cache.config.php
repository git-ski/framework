<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'cache' => [
        'default' => 'memory',
        'adapter' => [
            // 'memcached' => [
            //     'adapter' => [
            //         'name' => 'memcached',
            //         'options' => [
            //             'servers' => [
            //                 ['cache_server2', 11211]
            //             ],
            //             'ttl' => 3600,
            //             'namespace' => null,
            //         ],
            //     ]
            // ],
            // 'redis' => [
            //     'adapter' => [
            //         'name' => 'redis',
            //         'options' => [
            //             'server' => [
            //                 'host' => 'cache_server',
            //                 'port' => 6379,
            //             ],
            //             'ttl' => 3600,
            //             'namespace' => null,
            //             'lib_options' => [
            //                 // \Redis::OPT_SERIALIZER => \Redis::SERIALIZER_PHP,
            //             ],
            //         ],
            //     ]
            // ],
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
