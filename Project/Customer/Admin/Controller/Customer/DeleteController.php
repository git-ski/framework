<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Admin\Controller\Customer;

use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\Customer\Admin\View\ViewModel\Customer\DeleteViewModel;
use Project\Customer\Admin\Controller\Customer\DeleteModel as CustomerDeleteModel;
use Std\SessionManager\FlashMessage;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class DeleteController extends AbstractAdminController
{
    /**
     * Method index
     *
     * @param integer|str $id EntityId
     *
     * @return DeleteViewModel
     */
    public function index($id): DeleteViewModel
    {
        $CustomerDeleteModel = $this->getObjectManager()->get(CustomerDeleteModel::class);
        $Customer            = $CustomerDeleteModel->get($id);
        if (!$Customer) {
            $this->getRouter()->redirect(ListController::class);
        }
        return $this->getViewModelManager()->getViewModel([
            'viewModel' => DeleteViewModel::class,
            'data'      => [
                'customer'    => $Customer,
            ],
            'listeners' => [
                DeleteViewModel::TRIGGER_FORMFINISH => [$this, 'onDeleteFinish']
            ],
        ]);
    }

    /**
     * Method onDeleteFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onDeleteFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel = $event->getTarget();
        $customer = $ViewModel->getForm()->getData()['customer'];
        $CustomerDeleteModel = $this->getObjectManager()->get(CustomerDeleteModel::class);
        $Customer = $CustomerDeleteModel->get($customer['customerId']);
        $CustomerDeleteModel->delete($customer['customerId']);


        $this->triggerEvent(self::TRIGGER_AFTER_DELETE, $Customer);
        $this->getObjectManager()->get(FlashMessage::class)->add('FlashMessage', 'Deleted');
        $this->getRouter()->redirect(ListController::class, null, ['search'=>1]);
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "title"             => "顧客削除", // title
            'description'       => "顧客削除",
            "site_name"         => "secure framework", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "theme-light-blue",
            'priority'          => 0,
            'menu'              => false,
            'group'             => '顧客管理',
        ];
    }
}
