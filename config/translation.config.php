<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'translation' => [
        // 指定する言語の識別子は、zend-i18n-resourceに合わせる
        // https://github.com/laminas/laminas-i18n-resources/tree/master/languages
        'default'   => 'ja',
        'cache' => [
            // adapterを明示的に指定しない場合は、cache.config.phpの設定を援用する
            // 'adapter' => [
            //     'name' => 'memcached',
            //     'options' => [
            //         'servers' => ['cache_server2'],
            //         'ttl' => 3600,
            //         'namespace' => 'translation',
            //     ],
            // ]
        ],
        'language' => [
            'available' => [
                'ja' => '日本語',
                'en' => 'ENG',
            ],
            'selector' => [
                'default' => 'en',
            ],
            'detector' => [
                'type' => 'url',
                'domain' => [

                ],
                'url'    => [
                    'locales' => [
                        'ja', 'en'
                    ],
                    'pattern' => [
                        'match'     => '#^(/(?<locale>ja|en))?(/.*)?$#',
                        'replace'   => '/%s$3',
                    ]
                ],
                'cookie' => [
                    'name' => 'language',
                ]
            ]
        ],
    ]
];
