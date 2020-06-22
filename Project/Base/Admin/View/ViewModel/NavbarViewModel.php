<?php
declare(strict_types=1);

namespace Project\Base\Admin\View\ViewModel;

use Std\ViewModel\AbstractViewModel;

class NavbarViewModel extends AbstractViewModel
{
    protected $template = '/template/navbar.twig';

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
            ]
        ]
    ];

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
