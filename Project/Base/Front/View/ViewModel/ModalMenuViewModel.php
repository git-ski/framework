<?php
declare(strict_types=1);

namespace Project\Base\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;

class ModalMenuViewModel extends AbstractViewModel
{
    protected $template = "/template/modal_menu.twig";

    const MENU_TOP      = 'MenuTop';
    const MENU_MIDDLE   = 'MenuMiddle';
    const MENU_BOTTOM   = 'MenuBottom';

    protected $config = [
        'scripts' => [
        ],
        'styles' => [
        ],
        'container' => [
            self::MENU_TOP  => [
            ],
            self::MENU_MIDDLE => [
            ],
            self::MENU_BOTTOM => [
            ],
        ]
    ];

    public function getTemplateDir(): string
    {
        return __DIR__ . '/..';
    }
}
