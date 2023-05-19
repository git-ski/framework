<?php
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;
use Project\Base\Front\View\ViewModel\HeaderViewModel as BaseHeaderViewModel;
use Project\Customer\Front\View\ViewModel\BreadcrumbViewModel;

class HeaderViewModel extends BaseHeaderViewModel
{
    protected $template = "/template/header.twig";

    const NAVBAR_LEFT  = 'NavbarLeft';
    const NAVBAR_RIGHT = 'NavbarRight';

    protected $config = [
        'scripts' => [
        ],
        'styles' => [
        ],
        'container' => [
            self::NAVBAR_LEFT  => [
            ],
            self::NAVBAR_RIGHT => [
            ],
        ]
    ];


    public function getTemplateDir(): string
    {
        return __DIR__ . '/..';
    }
}
