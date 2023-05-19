<?php
declare(strict_types=1);

namespace Project\Customer\Front\Controller\Login;

use Project\Base\Front\Controller\AbstractController;
use Project\Base\Front\Controller\AuthControllerInterface;
use Project\Customer\Front\View\ViewModel\Login\LogoutViewModel;
use Project\Customer\Front\Controller\Login\LoginController;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;

class LogoutController extends AbstractController implements
    AuthControllerInterface,
    AuthenticationAwareInterface
{
    use \Std\Authentication\AuthenticationAwareTrait;

    public function index(): LogoutViewModel
    {
        if (!$this->getAuthentication()->hasIdentity()) {
            $this->getRouter()->redirect(LoginController::class);
        }
        $this->getAuthentication()->clearIdentity();
        return $this->getViewModelManager()->getViewModel([
            'viewModel' => LogoutViewModel::class
        ]);
    }

    public static function getPageInfo(): array
    {
        return [
            "description" => "Log Out ", //
            "title" => "Log In ", // title
            "site_name" => "site_name", // titleの|以降
            "lower_title" => "Log In ", // マイページ系の表示タイトル
            "meta_description" => "meta_description", // description
            "meta_keywords" => "meta_keywords", // keywords
            "og_title" => "og_title", // og:title
            "og_description" => "og_description", // og:description
            "og_site_name" => "og_site_name", // og:site_name
            "og_type" => "article", // og:type
            "priority" => 0,
            "menu" => false,
        ];
    }
}
