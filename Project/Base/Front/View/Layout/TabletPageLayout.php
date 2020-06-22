<?php

namespace Project\Base\Front\View\Layout;

use Std\ViewModel\PageLayout;
use Project\Base\Front\View\ViewModel\HeaderViewModel;
use Project\Base\Front\View\ViewModel\ModalMenuViewModel;
use Project\Base\Front\View\ViewModel\FooterViewModel;
use Project\Base\Front\View\ViewModel\GoogleAnalyticsViewModel;

class TabletPageLayout extends PageLayout
{
    protected $config = [
        'container' => [
            'Header' => [
            ],
            'Main' => [],
            'Footer' => [
                [
                    'viewModel' => GoogleAnalyticsViewModel::class
                ]
            ],
        ]
    ];

    protected $template = '/template/layout/front.twig';

    protected $asset = '/asset/';

    protected $styles = [
        '/paid/material/bootstrap/dist/css/bootstrap.min.css',
        '/paid/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css',
        '/paid/plugins/bower_components/toast-master/css/jquery.toast.css',
        '/paid/plugins/bower_components/morrisjs/morris.css',
        '/paid/plugins/bower_components/chartist-js/dist/chartist.min.css',
        '/paid/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css',
        '/paid/plugins/bower_components/calendar/dist/fullcalendar.css',
        '/paid/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css',
        '/paid/plugins/bower_components/custom-select/custom-select.css',
        '/paid/plugins/bower_components/switchery/dist/switchery.min.css',
        '/paid/plugins/bower_components/bootstrap-select/bootstrap-select.min.css',
        '/paid/plugins/bower_components/dropify/dist/css/dropify.min.css',
        '/paid/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css',
        '/paid/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css',
        '/paid/plugins/bower_components/multiselect/css/multi-select.css',
        '/paid/material/css/animate.css',
        '/paid/material/css/style.css',
        '/paid/material/css/colors/default.css',
        '/paid/material/css/customize.css',
    ];

    protected $scripts = [
        '/paid/plugins/bower_components/jquery/dist/jquery.min.js',
        '/paid/material/bootstrap/dist/js/bootstrap.min.js',
        '/paid/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js',
        '/paid/material/js/jquery.slimscroll.js',
        '/paid/material/js/waves.js',
        '/paid/plugins/bower_components/waypoints/lib/jquery.waypoints.js',
        '/paid/plugins/bower_components/counterup/jquery.counterup.min.js',
        '/paid/plugins/bower_components/raphael/raphael-min.js',
        '/paid/plugins/bower_components/morrisjs/morris.js',
        '/paid/plugins/bower_components/chartist-js/dist/chartist.min.js',
        '/paid/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js',
        '/paid/plugins/bower_components/dropify/dist/js/dropify.min.js',
        '/paid/plugins/bower_components/moment/moment.js',
        '/paid/plugins/bower_components/calendar/dist/fullcalendar.min.js',
        '/paid/plugins/bower_components/calendar/dist/cal-init.js',
        '/paid/plugins/bower_components/switchery/dist/switchery.min.js',
        '/paid/plugins/bower_components/custom-select/custom-select.min.js',
        '/paid/plugins/bower_components/bootstrap-select/bootstrap-select.min.js',
        '/paid/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js',
        '/paid/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js',
        '/paid/plugins/bower_components/multiselect/js/jquery.multi-select.js',
        '/paid/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js',
        '/paid/material/js/locales/bootstrap-datepicker.ja.js',
        '/paid/material/js/custom.js',
        '/paid/material/js/cbpFWTabs.js',
        '/paid/plugins/bower_components/toast-master/js/jquery.toast.js',
        '/paid/plugins/bower_components/styleswitcher/jQuery.style.switcher.js',
    ];

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
