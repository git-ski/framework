<?php
/**
 * PHP version 7
 * File ListController.php
 *
 * @category Controller
 * @package  Project\Base\Admin
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Admin\Controller\Vocabulary;

use Project\Base\Admin\Controller\AbstractAdminController;
use Project\Base\Admin\View\ViewModel\Vocabulary\ListViewModel;
use Project\Base\Admin\Controller\Vocabulary\ListModel as VocabularyHeaderListModel;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Std\SessionManager\SessionManagerAwareInterface;
use Project\Base\Api\Controller\Vocabulary\ListController as ApiListController;
use Std\CacheManager\CacheManagerAwareInterface;

/**
 * Class ListController
 *
 * @category Controller
 * @package  Project\Base\Admin
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class ListController extends AbstractAdminController implements
    HttpMessageManagerAwareInterface,
    SessionManagerAwareInterface,
    CacheManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;
    use \Std\CacheManager\CacheManagerAwareTrait;

    const SEARCH_SESSION_KEY = ApiListController::class;

    /**
     * Method index
     *
     * @return ListViewModel
     */
    public function index(): ListViewModel
    {
        $page = $this->getHttpMessageManager()->getRequest()->getQueryParams()['page'] ?? 1;

        $VocabularyHeaderListModel = $this->getObjectManager()->get(VocabularyHeaderListModel::class);
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

        $paginator = $VocabularyHeaderListModel->search($condition, $orderBy);
        $paginator->setCurrentPageNumber($page);

        $ViewModel = $this->getViewModelManager()->getViewModel([
            'viewModel' => ListViewModel::class,
            'data'      => [
                'vocabularyHeader' => $paginator,
                'orderBy'  => $orderBy
            ],
        ]);

        if (isset($this->getHttpMessageManager()->getRequest()->getQueryParams()['search'])) {
            $formData = $ViewModel->getForm()->getData();
            $formData['vocabularyHeader'] = $condition;
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
            "title"             => "マスタ一覧", // title
            "description"       => "マスタ一覧",
            "site_name"         => "gitski framework", // titleの|以降
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
            'group'             => ' マスター管理',
            'groupIcon'         => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>',
        ];
    }
}
