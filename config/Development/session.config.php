<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'session' => [
        'storage' => [
            'adapter' => [
                'name' => 'memory',
                'options' => [
                    'namespace' => null,
                ],
                // 'name' => 'redis',
                // 'options' => [
                //     'server' => [
                //         'host' => 'session_server',
                //         'port' => 6379,
                //     ],
                //     'ttl' => 3600,
                //     'namespace' => "session",
                //     'lib_options' => [
                //         \Redis::OPT_SERIALIZER => \Redis::SERIALIZER_PHP,
                //     ],
                // ],
            ]
        ],
        'options' => [
            'cookie_lifetime'       => 0,
            'remember_me_seconds'   => 24 * 3600,
            'name'                  => 'gitskisession',
            'gc_maxlifetime'        => 24 * 3600,
            'gc_divisor'            => 100,
            'gc_probability'        => 100,
        ],
        'namespaces' => [
            'default'
        ],
        'authentication' => [
            'auto_login' => 7 * 24 * 3600,
        ]
    ]
];
