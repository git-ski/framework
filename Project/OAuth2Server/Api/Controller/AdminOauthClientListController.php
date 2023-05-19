<?php
/**
 * PHP version 7
 * File AdminOauthClientListController.php
 *
 * @category Controller
 * @package  Project\OAuth2Server\Api
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\OAuth2Server\Api\Controller;

use Project\Base\Api\Controller\AbstractAdminRestfulController as AbstractRestfulController;
use Project\OAuth2Server\Admin\View\ViewModel\OauthClient\ListViewModel;
use Project\OAuth2Server\Admin\Controller\OauthClient\ListModel as OauthClientListModel;
use Project\Viewpack\Common\Layout\EmptyLayout;
use Std\SessionManager\SessionManagerAwareInterface;

class AdminOauthClientListController extends AbstractRestfulController implements
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
        $AdminOauthClientListModel = $this->getObjectManager()->get(AdminOauthClientListModel::class);
        $OauthClient = $AdminOauthClientListModel->get($id);
        if (!$OauthClient) {
            return $this->notFount();
        }
        $data = $OauthClient->toArray();
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

        $OauthClientListModel = $this->getObjectManager()->get(OauthClientListModel::class);

        $sessionManager = $this->getSessionManager();
        $sessionContainer = $sessionManager->getSession(__CLASS__);

        $paginator = $OauthClientListModel->search($condition, $orderBy);
        $paginator->setCurrentPageNumber($page);

        $ViewModel = $this->getViewModelManager()->getViewModel([
            'viewModel' => ListViewModel::class,
            'data'      => [
                'oauthClient' => $paginator,
                'orderBy'  => $orderBy
            ],
        ]);


        $formData = $ViewModel->getForm()->getData();
        $formData['oauthClient'] = $condition;
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
