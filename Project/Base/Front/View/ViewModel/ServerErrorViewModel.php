<?php
declare(strict_types=1);

namespace Project\Base\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;
use Project\Base\Front\View\Layout\SinglePageLayout;

class ServerErrorViewModel extends AbstractViewModel
{
    protected $template = '/template/error/500.twig';

    protected $config = [
        'layout' => SinglePageLayout::class,
    ];

    public function getTemplateDir(): string
    {
        return __DIR__ . '/..';
    }
}
