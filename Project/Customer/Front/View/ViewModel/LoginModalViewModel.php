<?php
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;

class LoginModalViewModel extends AbstractViewModel
{

    protected $template = "/template/login_modal.twig";

    protected $config = [
        'scripts' => [
        ],
        'styles' => [
        ],
        'container' => [
        ]
    ];

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
