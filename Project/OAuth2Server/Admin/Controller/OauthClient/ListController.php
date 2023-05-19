<?php
/**
 * PHP version 7
 * File ListController.php
 *
 * @category Controller
 * @package  Project\OAuth2Server\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\OAuth2Server\Admin\Controller\OauthClient;

use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\OAuth2Server\Admin\View\ViewModel\OauthClient\ListViewModel;
use Project\OAuth2Server\Admin\Controller\OauthClient\ListModel as OauthClientListModel;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Std\SessionManager\SessionManagerAwareInterface;
use Project\OAuth2Server\Admin\Controller\AdminOauthClientListController as ApiListController;

/**
 * Class ListController
 *
 * @category Controller
 * @package  Project\OAuth2Server\Admin
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

    const SEARCH_SESSION_KEY = ApiListController::class;

    /**
     * Method index
     *
     * @return ListViewModel
     */
    public function index(): ListViewModel
    {
        $page = $this->getHttpMessageManager()->getRequest()->getQueryParams()['page'] ?? 1;

        $OauthClientListModel = $this->getObjectManager()->get(OauthClientListModel::class);

        $Session = $this->getSessionManager()->getSession(self::SEARCH_SESSION_KEY);
        $condition = [];
        $orderBy = [];
        if (isset($this->getHttpMessageManager()->getRequest()->getQueryParams()['search'])) {
            $condition = $Session->condition;
            $page = $Session->page;
            $orderBy = $Session->orderBy;
        } else {
            $Session->getManager()->getStorage()->clear(self::SEARCH_SESSION_KEY);
        }

        $paginator = $OauthClientListModel->search($condition, $orderBy);
        $paginator->setCurrentPageNumber($page);

        $ViewModel = $this->getViewModelManager()->getViewModel([
            'viewModel' => ListViewModel::class,
            'data'      => [
                'oauthClient' => $paginator,
                'orderBy'  => $orderBy
            ],
        ]);

        if (isset($this->getHttpMessageManager()->getRequest()->getQueryParams()['search'])) {
            $formData = $ViewModel->getForm()->getData();
            $formData['oauthClient'] = $condition;
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
            "title"             => "OauthClient 一覧", // title
            "description"       => "OauthClient 一覧",
            "site_name"         => "secure framework", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "theme-light-blue",
            'priority'          => 1,
            'menu'              => true,
            'icon'              => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>',
            'group'             => 'OauthClient 管理',
            'groupIcon'         => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>',
        ];
    }
}
