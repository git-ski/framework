<?php

namespace Project\Base\Admin\View\Layout;

use Std\ViewModel\PageLayout;
use Project\Base\Admin\View\ViewModel\NavbarViewModel;
use Project\Base\Admin\View\ViewModel\SidemenuViewModel;
use Framework\ObjectManager\ObjectManager;
use Std\Controller\ControllerInterface;

class AdminPageLayout extends PageLayout
{
    protected $config = [
        'container' => [
            'Header' => [
                [
                    'viewModel' => NavbarViewModel::class,
                ],
                [
                    'viewModel' => SidemenuViewModel::class
                ],
            ],
            'Main' => [],
            'Footer' => []
        ]
    ];

    protected $template = '/template/layout/admin.twig';

    protected $asset = '/asset';

    protected $styles = [
        "https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext",
        "https://fonts.googleapis.com/icon?family=Material+Icons",
        "/material/plugins/bootstrap/css/bootstrap.min.css",
        "/material/plugins/bootstrap-select/css/bootstrap-select.css",
        "/material/plugins/animate-css/animate.css",
        "/material/css/style.css",
        "/material/css/themes/all-themes.css",
        "/material/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css",
        "/material/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css",
        "/admin/css/style.css",
    ];

    protected $scripts = [
        "https://cdn.jsdelivr.net/npm/vue@2.5.22/dist/vue.runtime.min.js",
        "/material/plugins/jquery/jquery.min.js",
        "/material/plugins/bootstrap/js/bootstrap.js",
        "/material/plugins/jquery-slimscroll/jquery.slimscroll.js",
        "/material/js/admin.js",
        "/material/plugins/momentjs/moment.js",
        "/material/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js",
        "/material/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js",
        "/common/js/datepicker-ja.js",
        "/admin/js/datepicker.js",
        "/admin/js/jquery.repeater.js",
        "/admin/js/repeater.js",
    ];

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
