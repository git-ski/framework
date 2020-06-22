<?php

namespace Project\Base\Front\View\Layout;

use Std\ViewModel\PageLayout;
use Project\Base\Front\View\ViewModel\HeaderViewModel;
use Project\Base\Front\View\ViewModel\FooterViewModel;
use Project\Base\Front\View\ViewModel\GoogleAnalyticsViewModel;

class SinglePageLayout extends PageLayout
{
    protected $config = [
        'container' => [
            'Main' => [],
            'Footer' => [
                [
                    'viewModel' => GoogleAnalyticsViewModel::class
                ]
            ],
        ]
    ];

    protected $template = '/template/layout/front.twig';

    protected $asset = '/asset';

    protected $styles = [
        '/material/plugins/bootstrap/css/bootstrap.min.css',
        '/material/css/style.css',
    ];

    protected $scripts = [
    ];

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
