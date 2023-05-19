<?php
declare(strict_types=1);

namespace Project\AdminUser\Admin\Controller;

use Std\Controller\AbstractController;
use Std\ViewModel\ViewModelManager;
use Project\Base\AdminUser\View\ViewModel\LoginViewModel;
use Project\Base\Admin\Controller\AbstractAdminController;
use Project\AdminUser\Admin\Controller\LoginController;
use Project\AdminUser\Admin\Authentication\AuthenticationAwareInterface;

class LogoutController extends AbstractAdminController implements
    AuthenticationAwareInterface
{
    use \Std\Authentication\AuthenticationAwareTrait;

    public function index(): void
    {
        $this->getAuthentication()->clearIdentity();
        $this->getRouter()->redirect(LoginController::class);
    }

    public static function getPageInfo(): array
    {
        return [
            "description" => "ログアウト",
            "priority" => 99,
            "menu" => true,
            'icon' => '<i class="mdi mdi-logout fa-fw"></i>',
        ];
    }
}
