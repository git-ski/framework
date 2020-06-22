<?php
/**
 * PHP version 7
 * File AdminListController.php
 *
 * @category Controller
 * @package  Project\Base\Api
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Api\Controller;

use Project\Base\Api\Controller\AbstractRestfulController;
use Project\Base\Admin\View\ViewModel\Vocabulary\ListViewModel;
use Project\Base\Admin\Controller\Vocabulary\ListModel as VocabularyHeaderListModel;
use Project\Viewpack\Common\Layout\EmptyLayout;
use Std\SessionManager\SessionManagerAwareInterface;

class AdminVocabularyListController extends AbstractRestfulController implements
    SessionManagerAwareInterface
{
    use \Std\SessionManager\SessionManagerAwareTrait;

    /**
     * 参照(一件)
     *
     * @param integer $id 参照対象id
     * @return array レスポンス
     */
    public function get($id)
    {
        $AdminListModel = $this->getObjectManager()->get(AdminListModel::class);
        $VocabularyHeader = $AdminListModel->get($id);
        if (!$VocabularyHeader) {
            return $this->notFount();
        }
        $data = $VocabularyHeader->toArray();
        // データをフォーマット

        return [
            'success' => true,
            'data' => $data
        ];
    }

    /**
     * 参照(複数)
     *
     * @param array $data 検索条件
     * @return array レスポンス
     */
    public function getList()
    {
        $page = $this->getHttpMessageManager()->getRequest()->getQueryParams()['page'] ?? 1;
        $condition = $this->getHttpMessageManager()->getRequest()->getQueryParams()['condition'] ?? [];
        $orderBy = $this->getHttpMessageManager()->getRequest()->getQueryParams()['sort'] ?? [];
        $VocabularyHeaderListModel = $this->getObjectManager()->get(VocabularyHeaderListModel::class);

        $sessionManager = $this->getSessionManager();
        $sessionContainer = $sessionManager->getSession(__CLASS__);

        $paginator = $VocabularyHeaderListModel->search($condition, $orderBy);
        $paginator->setCurrentPageNumber($page);

        $ViewModel = $this->getViewModelManager()->getViewModel([
            'viewModel' => ListViewModel::class,
            'data'      => [
                'vocabularyHeader' => $paginator,
                'orderBy'  => $orderBy
            ],
        ]);


        $formData = $ViewModel->getForm()->getData();
        $formData['vocabularyHeader'] = $condition;
        $ViewModel->getForm()->setData($formData);

        $sessionContainer->condition = $condition;
        $sessionContainer->page = $page;
        $sessionContainer->orderBy = $orderBy;

        $ViewModel->setLayout(new EmptyLayout());

        return [
            'success' => true,
            'data' => [
                'content' => $ViewModel->Render()
            ]
        ];
    }
}
