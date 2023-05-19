<?php
/**
 * PHP version 7
 * File ListController.php
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\AdminUser\Admin\Controller\AdminUser;

use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\AdminUser\Admin\View\ViewModel\AdminUser\ListViewModel;
use Std\SessionManager\SessionManagerAwareInterface;
use Project\AdminUser\Api\Controller\AdminController;
/**
 * Class ListController
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ListController extends AbstractAdminController implements SessionManagerAwareInterface
{
    use \Std\SessionManager\SessionManagerAwareTrait;
    const SEARCH_SESSION_KEY = AdminController::class;
    /**
     * Method index
     *
     * @return ListViewModel
     */
    public function index(): ListViewModel
    {
        $page = $this->getHttpMessageManager()->getRequest()->getQueryParams()['page'] ?? 1;

        $ListModel = $this->getObjectManager()->get(ListModel::class);

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

        $paginator = $ListModel->search($condition, $orderBy);
        $paginator->setCurrentPageNumber($page);

        $ViewModel = $this->getViewModelManager()->getViewModel([
            'viewModel' => ListViewModel::class,
            'data'      => [
                'admin' => $paginator,
                'orderBy'  => $orderBy
            ],
        ]);

        if (isset($this->getHttpMessageManager()->getRequest()->getQueryParams()['search'])) {
            $formData = $ViewModel->getForm()->getData();
            $formData['admin'] = $condition;
            $ViewModel->getForm()->setData($formData);
        }

        return $ViewModel;
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "title"             => "管理者 一覧", // title
            "description"       => "管理者 一覧",
            "site_name"         => "git-ski", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "theme-light-blue",
            'priority'          => 51,
            'menu'              => true,
            'icon'              => '<i class="mdi mdi-play fa-fw" data-icon="v"></i>',
            'group'             => '管理者管理',
            'groupIcon'         => '<i class="mdi mdi-menu fa-fw" data-icon="v"></i>',
        ];
    }
}
