<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'oauth' => [
        'key' => [
            'privatePath' => 'key://rs256.private',
            'publicPath' => 'key://rs256.public',
        ],
        'encryption'  => 'lxZFUEsBCJ2Yb14IF2ygAHI5N4+ZAUXXaSeeJm6+twsUmIen',
        'scopes' => [
            'basic' => [
                'description' => '基本情報',
                'details'     => [
                    'nameSei', 'nameMei',
                ]
            ],
            'email' => [
                'description' => 'メールアドレス',
                'details'     => [
                    'email'
                ]
            ],
        ],
        // 付与する各情報の有効期間
        'grants' => [
            'authenticationCode' => 'PT10M', // 認証コード有効期間：10分
            'refreshToken'        => 'P1M',   // refreshToken有効期間：１ヶ月
            'accessToken'         => 'PT1H'   // accessToken有効期間：１時間
        ]
    ],
];
