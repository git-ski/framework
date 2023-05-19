<?php
/**
 * PHP version 7
 * File WithdrawController.php
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
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;
use Project\Base\Front\Controller\AbstractController;
use Std\ViewModel\ViewModelManager;
use Project\Customer\Front\View\ViewModel\Customer\WithdrawViewModel;
use Project\Customer\Front\Controller\Customer\WithdrawModel as CustomerWithdrawModel;
use Project\Customer\Front\Controller\Login\LoginController;
use Project\Customer\Front\Controller\Customer\ProfileController;

/**
 * Class WithdrawController
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class WithdrawController extends AbstractController implements
    AuthControllerInterface,
    AuthenticationAwareInterface
{
    use \Std\Authentication\AuthenticationAwareTrait;

    /**
     * Method index
     *
     * @param integer|str $id EntityId
     *
     * @return WithdrawViewModel
     */
    public function index(): WithdrawViewModel
    {
        $identity = $this->getAuthentication()->getIdentity();
        $CustomerWithdrawModel = $this->getObjectManager()->get(CustomerWithdrawModel::class);
        $Customer = $CustomerWithdrawModel->get($identity['customerId']);

        $isExistReservation = $CustomerWithdrawModel->checkReservationIsExist($Customer);

        return $this->getViewModelManager()->getViewModel([
            'viewModel' => WithdrawViewModel::class,
            'data'      => [
                'customer'    => $Customer,
                'isExistFlag' => ($isExistReservation) ? true : false
            ],
            'listeners' => [
                WithdrawViewModel::TRIGGER_FORMFINISH => [$this, 'onWithdrawFinish']
            ],
        ]);
    }

    /**
     * Method onWithdrawFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onWithdrawFinish(\Framework\EventManager\Event $event): void
    {
        $identity = $this->getAuthentication()->getIdentity();
        $CustomerWithdrawModel = $this->getObjectManager()->get(CustomerWithdrawModel::class);
        $Customer = $CustomerWithdrawModel->get($identity['customerId']);
        // 予約情報がある場合、マイページへ遷移する
        if ($CustomerWithdrawModel->checkReservationIsExist($Customer)) {
            $this->getRouter()->redirect(ProfileController::class);
        }

        $ViewModel = $event->getTarget();
        $customer = $ViewModel->getForm()->getData()['customer'];
        $Customer = $CustomerWithdrawModel->get($customer['customerId']);
        $CustomerWithdrawModel->withdraw($Customer, $customer);
        $this->getAuthentication()->clearIdentity();
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "description" => "Membership Withdrawal", //
            "title" => "Membership Withdrawal", // title
            "site_name" => "site_name", // titleの|以降
            "lower_title" => "Membership Withdrawal", // マイページ系の表示タイトル
            "meta_description" => "meta_description", // description
            "meta_keywords" => "meta_keywords", // keywords
            "og_title" => "og_title", // og:title
            "og_description" => "og_description", // og:description
            "og_site_name" => "og_site_name", // og:site_name
            "og_type" => "article", // og:type
            'priority'      => 0,
            'menu'          => false,
        ];
    }
}
