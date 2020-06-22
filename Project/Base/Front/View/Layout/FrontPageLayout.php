<?php

namespace Project\Base\Front\View\Layout;

use Std\ViewModel\PageLayout;
use Project\Base\Front\View\ViewModel\HeaderViewModel;
use Project\Base\Front\View\ViewModel\ModalMenuViewModel;
use Project\Base\Front\View\ViewModel\FooterViewModel;
use Project\Base\Front\View\ViewModel\GoogleAnalyticsViewModel;

class FrontPageLayout extends PageLayout
{
    protected $config = [
        'container' => [
            'Header' => [
                [
                    'viewModel' => HeaderViewModel::class,
                ],
                [
                    'viewModel' => ModalMenuViewModel::class,
                ],
            ],
            'Main' => [],
            'Footer' => [
                [
                    'viewModel' => FooterViewModel::class,
                ],
                [
                    'viewModel' => GoogleAnalyticsViewModel::class
                ]
            ],
        ]
    ];

    protected $template = '/template/layout/front.twig';

    protected $asset = '/asset';

    protected $styles = [
        'https://fonts.googleapis.com/css?family=Montserrat:400,600',
        'https://fonts.googleapis.com/css?family=Noto+Sans',
        '/material/plugins/bootstrap/css/bootstrap.min.css',
        '/material/css/style.css',
    ];

    protected $scripts = [
        'https://code.jquery.com/jquery-3.3.1.min.js',
        '/front/js/app.js',
    ];

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
