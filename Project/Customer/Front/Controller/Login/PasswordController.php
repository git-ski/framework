<?php
/**
 * PHP version 7
 * File EditController.php
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\Controller\Login;

use Project\Base\Front\Controller\AuthControllerInterface;
use Project\Base\Front\Controller\AbstractController;
use Std\ViewModel\ViewModelManager;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;
use Project\Customer\Front\Controller\Customer\PasswordController as CustomerPasswordController;
use Project\Customer\Front\View\ViewModel\Customer\PasswordViewModel as CustomerPasswordViewModel;
use Project\Customer\Front\View\ViewModel\Login\PasswordViewModel;
use Project\Customer\Front\Controller\Login\PasswordModel as LoginPasswordModel;
use Project\Customer\Front\Controller\Login\LoginController as LoginController;

/**
 * Class EditController
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class PasswordController extends CustomerPasswordController
{
    use \Std\Authentication\AuthenticationAwareTrait;

    protected $viewModel = PasswordViewModel::class;

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "description" => "Change Your Password", //
            "title" => "Change Your Password", // title
            "site_name" => "site_name", // titleの|以降
            "lower_title" => "Change Your Password", // マイページ系の表示タイトル
            "meta_description" => "meta_description", // description
            "meta_keywords" => "meta_keywords", // keywords
            "og_title" => "og_title", // og:title
            "og_description" => "og_description", // og:description
            "og_site_name" => "og_site_name", // og:site_name
            "og_type" => "article", // og:type
            'priority' => 0,
            'menu' => false,
        ];
    }
}
