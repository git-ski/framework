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
use Project\Customer\Front\View\ViewModel\Customer\EditViewModel;
use Project\Customer\Front\Controller\Customer\EditModel as CustomerEditModel;
use Project\Language\LocaleDetector\Front;
use Project\Base\Model\CountryModel;

/**
 * Class EditController
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EditController extends AbstractController implements
    AuthControllerInterface,
    AuthenticationAwareInterface
{
    use \Std\Authentication\AuthenticationAwareTrait;

    /**
     * Method index
     *
     * @param integer|str $id EntityId
     *
     * @return EditViewModel
     */
    public function index(): EditViewModel
    {
        $identity = $this->getAuthentication()->getIdentity();
        $CustomerEditModel = $this->getObjectManager()->get(CustomerEditModel::class);
        $Customer = $CustomerEditModel->get($identity['customerId']);

        $locale = $this->getObjectManager()->get(Front::class)->getLocale();
        $isLocaleJapan = false;
        if ($locale == CountryModel::LANGUAGE_JAPAN) {
            $isLocaleJapan = true;
        }

        return $this->getViewModelManager()->getViewModel([
            'viewModel' => EditViewModel::class,
            'data'      => [
                'customer' => $Customer,
                'isLocaleJapan' => $isLocaleJapan,
            ],
            'listeners' => [
                EditViewModel::TRIGGER_FORMFINISH => [$this, 'onEditFinish']
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
        $ViewModel = $event->getTarget();
        $customer = $ViewModel->getForm()->getData()['customer'];
        // セッション切れたり、別ユーザーでログインし直したりの場合
        // 更新処理をせずに、画面をリロードして情報を最新に表示する
        $identity = $this->getAuthentication()->getIdentity();
        if ($customer['customerId'] != $identity['customerId']) {
            $this->getRouter()->reload();
        }
        $CustomerEditModel = $this->getObjectManager()->get(CustomerEditModel::class);
        $Customer = $CustomerEditModel->get($customer['customerId']);
        $CustomerEditModel->update($Customer, $customer);
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "description" => "Modify Personal Info", //
            "title" => "Modify Personal Info", // title
            "site_name" => "site_name", // titleの|以降
            "lower_title" => "Modify Personal Info", // マイページ系の表示タイトル
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
