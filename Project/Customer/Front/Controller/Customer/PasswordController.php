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
use Project\Customer\Front\View\ViewModel\Customer\PasswordViewModel;
use Project\Customer\Front\Controller\Customer\PasswordModel as CustomerPasswordModel;
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
class PasswordController extends AbstractController implements
    AuthControllerInterface,
    AuthenticationAwareInterface
{
    use \Std\Authentication\AuthenticationAwareTrait;

    protected $viewModel = PasswordViewModel::class;

    /**
     * Method index
     *
     * @param integer|str $id EntityId
     *
     * @return PasswordViewModel
     */
    public function index(): PasswordViewModel
    {
        $identity = $this->getAuthentication()->getIdentity();
        $CustomerPasswordModel = $this->getObjectManager()->get(CustomerPasswordModel::class);
        $Customer = $CustomerPasswordModel->get($identity['customerId']);

        return $this->getViewModelManager()->getViewModel([
            'viewModel' => $this->viewModel,
            'data'      => [
                'customer' => $Customer,
            ],
            'listeners' => [
                PasswordViewModel::TRIGGER_FORMFINISH => [$this, 'onEditFinish']
            ],
        ]);
    }

    /**
     * Method onEditFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onEditFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel                  = $event->getTarget();
        $customer                   = $ViewModel->getForm()->getData()['customer'];
        // セッション切れたり、別ユーザーでログインし直したりの場合
        // 更新処理をせずに、画面をリロードして情報を最新に表示する
        $identity = $this->getAuthentication()->getIdentity();
        if ($customer['customerId'] != $identity['customerId']) {
            $this->getRouter()->reload();
        }
        $CustomerPasswordModel = $this->getObjectManager()->get(CustomerPasswordModel::class);
        $Customer = $CustomerPasswordModel->get($customer['customerId']);
        $CustomerPasswordModel->update($Customer, $customer);
        $this->getAuthentication()->updateIdentity(['tempPasswordFlag' => 0]);
    }

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
            'menu' => false
        ];
    }
}
