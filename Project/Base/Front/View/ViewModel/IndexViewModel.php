<?php
declare(strict_types=1);

namespace Project\Base\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;
use Project\Base\Front\View\Layout\FrontPageLayout;

class IndexViewModel extends AbstractViewModel
{
    protected $template = '/template/index.twig';

    protected $config = [
        'layout' => FrontPageLayout::class,
        'container' => [
            'Main' => [
                [
                    'viewModel' => ContentViewModel::class,
                ],
            ],
        ],
    ];

    public function getTemplateDir(): string
    {
        return __DIR__ . '/..';
    }
}
