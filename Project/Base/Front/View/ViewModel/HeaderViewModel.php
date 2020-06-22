<?php
declare(strict_types=1);

namespace Project\Base\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;

class HeaderViewModel extends AbstractViewModel
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
