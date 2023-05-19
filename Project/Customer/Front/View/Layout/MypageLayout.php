<?php

namespace Project\Customer\Front\View\Layout;

use Std\ViewModel\PageLayout;
use Project\Customer\Front\View\ViewModel\HeaderViewModel;
use Project\Customer\Front\View\ViewModel\ModalMenuViewModel;
use Project\Customer\Front\View\ViewModel\SubnavViewModel;
use Project\Customer\Front\View\ViewModel\FooterViewModel;
use Project\Base\Front\View\ViewModel\GoogleAnalyticsViewModel;

class MypageLayout extends PageLayout
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
            'Subnav' => [],
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

    protected $template = '/template/layout/mypage.twig';

    protected $asset = '/asset/front';

    protected $styles = [
        "https://fonts.googleapis.com/css?family=Montserrat:400,600",
        "https://fonts.googleapis.com/css?family=Noto+Sans",
        "https://unpkg.com/ionicons@4.2.0/dist/css/ionicons.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.0/flatpickr.css",
        "https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/css/swiper.min.css",
        "/css/style.css"
    ];

    protected $scripts = [
        "https://code.jquery.com/jquery-3.3.1.min.js",
        "/js/app.js",
    ];

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
