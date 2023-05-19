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

namespace Project\Customer\Front\Controller\Customer;

use Project\Base\Front\Controller\AuthControllerInterface;
use Project\Base\Front\Controller\AbstractController;
use Std\ViewModel\ViewModelManager;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;
use Project\Customer\Front\View\ViewModel\Customer\ProfileViewModel;
use Project\Customer\Front\Controller\Customer\EditModel as CustomerModel;
use Project\Customer\Front\Controller\Customer\ProfileModel;
use Project\Customer\Front\Controller\Login\LoginController;

/**
 * Class EditController
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ProfileController extends AbstractController implements
    AuthControllerInterface,
    AuthenticationAwareInterface
{
    use \Std\Authentication\AuthenticationAwareTrait;

    /**
     * Method index
     *
     * @param integer|str $id EntityId
     *
     * @return ProfileViewModel
     */
    public function index(): ProfileViewModel
    {
        $identity = $this->getAuthentication()->getIdentity();
        $CustomerModel = $this->getObjectManager()->get(ProfileModel::class);
        $Customer = $CustomerModel->get($identity['customerId']);

        return $this->getViewModelManager()->getViewModel([
            'viewModel' => ProfileViewModel::class,
            'data'      => [
                'customer' => $Customer,
                'isMyPage' => true
            ],
        ]);
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "description" => "My Account", //
            "title" => "My Account", // title
            "site_name" => "site_name", // titleの|以降
            "lower_title" => "My Account", // マイページ系の表示タイトル
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
