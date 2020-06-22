<?php
declare(strict_types=1);

namespace Project\Base\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;
use Project\Base\Front\View\Layout\SinglePageLayout;

class NotFoundViewModel extends AbstractViewModel
{
    protected $template = '/template/error/404.twig';

    protected $config = [
        'layout' => SinglePageLayout::class,
    ];

    public function getTemplateDir(): string
    {
        return __DIR__ . '/..';
    }
}
