<?php
declare(strict_types=1);

namespace Project\Base\Admin\View\ViewModel;

use Std\ViewModel\AbstractViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;

class DashboardViewModel extends AbstractViewModel
{
    protected $template = '/template/dashboard.twig';

    protected $config = [
        'layout' => AdminPageLayout::class,
        'container' => [
            'Main' => [
                [
                    'viewModel' => SummaryViewModel::class,
                ],
            ],
        ],
        'scripts' => [
        ]
    ];

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
