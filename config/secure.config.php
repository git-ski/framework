<?php
// @codingStandardsIgnoreFile
declare(strict_types=1);

return [
    'secure' => [
        'form' => [
            'csrf_timeout' => 1800, // sessionの生存期間より長く設定することはできません
        ],
        'admin' => [
            'login_attempt_limit' => 10, // 管理者ログイン失敗回数
            'login_attempt_lock' => 1800, // 管理者ログインロック時間(秒単位)
            'login_simultaneous' => 10, // 同時ログイン可能数
            'password_deny_generation' => 3, // 管理者パスワード変更世代制限
        ],
        'front' => [
            'login_attempt_limit' => 10, // フロントログイン失敗回数
            'login_attempt_lock' => 1800, // フロントログインロック時間(秒単位)
            'login_simultaneous' => null, // 同時ログイン可能数(nullが無制限)
            'password_deny_generation' => 3, // フロントパスワード変更世代制限
        ],
        'http_response' => [
            'header' => [
                // https://www.owasp.org/index.php/OWASP_Secure_Headers_Project#tab=Headers
                'X-Content-Type-Options' => 'nosniff',
                'X-Frame-Options' => 'SAMEORIGIN',
                'Content-Type' => 'text/html; charset=UTF-8',
                'Strict-Transport-Security' => 'max-age=86400; includeSubDomains',
                'X-Download-Options' => 'noopen',
                // 'X-XSS-Protection' => '1; mode=block', // Apacheの設定重複により、Apacheの設定を優先する。
                'X-Permitted-Cross-Domain-Policies' => 'none',
                'Referrer-Policy' => 'no-referrer',
            ],
        ],
        'restful' => [
            'header' => [
                'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
                'Allow' => 'GET, POST, PUT, DELETE, OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type, Origin, X-Requested-With, Accept, Accept-Language, Authentication',
            ]
        ],
        // Content Security Policy
        'content_security_policy' => [
            'report-only' => false,
            'report-uri' => '',
            'base-uri' => [],
            'default-src' => [],
            'child-src' => [
                'allow' => [
                    'https://www.google.com',
                ],
                'self' => false
            ],
            'connect-src' => [
                'allow' => [
                ],
                'self' => true
            ],
            'font-src' => [
                'allow' => [
                    'https://fonts.gstatic.com',
                ],
                'self' => true
            ],
            'form-action' => [
                'allow' => [
                ],
                'self' => true
            ],
            'frame-ancestors' => [],
            'img-src' => [
                'allow' => [
                    'https://www.google-analytics.com/',
                ],
                'self' => true,
                'data' => true,
            ],
            'media-src' => [],
            'object-src' => [],
            'plugin-types' => [],
            'script-src' => [
                'allow' => [
                    'https://ajax.googleapis.com/',
                    'https://www.google-analytics.com',
                    'https://www.google.com',
                    'https://www.gstatic.com',
                    'https://code.jquery.com',
                    'https://cdn.jsdelivr.net',
                ],
                'self' => true,
                'unsafe-inline' => true,
            ],
            'style-src' => [
                'allow' => [
                    'https://fonts.googleapis.com',

                ],
                'self' => true,
                'unsafe-inline' => true,
            ],
            'upgrade-insecure-requests' => true
        ]
    ],
];
