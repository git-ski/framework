<?php
/**
 * PHP version 7
 * File EditController.php
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
use Project\Customer\Admin\View\ViewModel\Customer\EditViewModel;
use Project\Customer\Admin\Controller\Customer\EditModel as CustomerEditModel;
use Std\SessionManager\FlashMessage;

/**
 * Class EditController
 *
 * @category Controller
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EditController extends AbstractAdminController
{
    /**
     * Method index
     *
     * @param integer|str $id EntityId
     *
     * @return EditViewModel
     */
    public function index($id): EditViewModel
    {
        $CustomerEditModel = $this->getObjectManager()->get(CustomerEditModel::class);
        $Customer = $CustomerEditModel->get($id);
        if (!$Customer) {
            $this->getRouter()->redirect(ListController::class);
        }
        return $this->getViewModelManager()->getViewModel([
            'viewModel' => EditViewModel::class,
            'data'      => [
                'customer' => $Customer,
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
        $CustomerEditModel = $this->getObjectManager()->get(CustomerEditModel::class);
        $Customer = $CustomerEditModel->get($customer['customerId']);
        $CustomerEditModel->update($Customer, $customer);
        $this->triggerEvent(self::TRIGGER_AFTER_UPDATE, $Customer);

        $this->getObjectManager()->get(FlashMessage::class)->add('FlashMessage', 'Updated');
        $this->getRouter()->reload();
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "title"             => "顧客編集", // title
            'description'       => "顧客編集",
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
