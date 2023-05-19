<?php
/**
 * PHP version 7
 * File ListController.php
 *
 * @category Controller
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Admin\Controller\Customer;

use Framework\Application\HttpApplication;
use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\Customer\Admin\View\ViewModel\Customer\ListViewModel;
use Project\Customer\Admin\Controller\Customer\ListModel as CustomerListModel;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Std\SessionManager\SessionManagerAwareInterface;
use Project\Customer\Api\Controller\CustomerListController;

/**
 * Class ListController
 *
 * @category Controller
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ListController extends AbstractAdminController implements
    HttpMessageManagerAwareInterface,
    SessionManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;

    const SEARCH_SESSION_KEY = CustomerListController::class;
    /**
     * Method index
     *
     * @return ListViewModel
     */
    public function index(): ListViewModel
    {
        /* URLから現在のページナンバーを取得し、Paginatorに渡してデータを取得します */
        $page = $this->getHttpMessageManager()->getRequest()->getQueryParams()['page'] ?? 1;

        $CustomerListModel = $this->getObjectManager()->get(CustomerListModel::class);

        $sessionManager = $this->getSessionManager();
        $sessionContainer = $sessionManager->getSession(self::SEARCH_SESSION_KEY);
        $condition = [];
        $orderBy = [];
        if (isset($this->getHttpMessageManager()->getRequest()->getQueryParams()['search'])) {
            $condition = $sessionContainer->condition;
            $page = $sessionContainer->page;
            $orderBy = $sessionContainer->orderBy;
        } else {
            $sessionContainer->getManager()->getStorage()->clear(self::SEARCH_SESSION_KEY);
        }

        $paginator = $CustomerListModel->search($condition, $orderBy);
        $paginator->setCurrentPageNumber($page);
        $ViewModel = $this->getViewModelManager()->getViewModel([
            'viewModel'     => ListViewModel::class,
            'data'      => [
                'condition' => $condition,
                'customer'  => $paginator,
                'orderBy'   => $orderBy
            ],
            'listeners' => [
                ListViewModel::TRIGGER_FORMSUBMIT => [$this, 'onSubmit']
            ]
        ]);

        return $ViewModel;
    }

    public function onSubmit(\Framework\EventManager\Event $event): void
    {
        $ViewModel = $event->getTarget();
        $formData = $ViewModel->getForm()->getData();
        if (isset($formData['customer']['exportCsv'])) {
            $sessionManager = $this->getSessionManager();
            $sessionContainer = $sessionManager->getSession(self::SEARCH_SESSION_KEY);

            $condition = $sessionContainer->condition ?? [];
            $orderBy = $sessionContainer->orderBy ?? [];

            $CustomerListModel = $this->getObjectManager()->get(CustomerListModel::class);
            $ExportImportModel = $this->getObjectManager()->get(ExportImportModel::class);

            $paginator = $CustomerListModel->search($condition, $orderBy);
            $ExportImportModel->export($paginator);

            $this->getObjectManager()->get(HttpApplication::class)->exit();
        }
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "title"             => "顧客一覧", // title
            'description'       => "顧客一覧",
            "site_name"         => "secure framework", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "theme-light-blue",
            'priority'          => 31,
            'menu'              => true,
            'icon'              => '<i class="mdi mdi-play fa-fw" data-icon="v"></i>',
            'group'             => '顧客管理',
            'groupIcon'         => '<i class="mdi mdi-menu fa-fw" data-icon="v"></i>',
        ];
    }
}
