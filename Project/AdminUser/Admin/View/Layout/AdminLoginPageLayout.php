<?php

namespace Project\AdminUser\Admin\View\Layout;

use Project\Base\Admin\View\Layout\AdminPageLayout;

class AdminLoginPageLayout extends AdminPageLayout
{
    protected $config = [
        'container' => [
            'Main' => [],
        ]
    ];

    protected $styles = [
        "https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext",
        "https://fonts.googleapis.com/icon?family=Material+Icons",
        "/material/plugins/bootstrap/css/bootstrap.min.css",
        "/material/plugins/animate-css/animate.css",
        "/material/css/style.css",
    ];

    protected $scripts = [
    ];
}
