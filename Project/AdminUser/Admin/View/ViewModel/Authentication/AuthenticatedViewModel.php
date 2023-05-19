<?php
declare(strict_types=1);

namespace Project\AdminUser\Admin\View\ViewModel\Authentication;

use Std\ViewModel\AbstractViewModel;

class AuthenticatedViewModel extends AbstractViewModel
{
    protected $template = '/template/authencation/authenticated.twig';

    public function getTemplateDir()
    {
        return __DIR__ . '/../..';
    }
}
