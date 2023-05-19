<?php
/**
 * PHP version 7
 * File AdminInquiryActionListController.php
 *
 * @category Controller
 * @package  Project\Inquiry\Api
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Inquiry\Api\Controller;

use Project\Base\Api\Controller\AbstractAdminRestfulController as AbstractRestfulController;
use Project\Inquiry\Admin\View\ViewModel\InquiryAction\ListViewModel;
use Project\Inquiry\Admin\Controller\InquiryAction\ListModel as InquiryActionListModel;
use Project\Viewpack\Common\Layout\EmptyLayout;
use Std\SessionManager\SessionManagerAwareInterface;

class AdminInquiryActionListController extends AbstractRestfulController implements
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
        $AdminInquiryActionListModel = $this->getObjectManager()->get(AdminInquiryActionListModel::class);
        $InquiryAction = $AdminInquiryActionListModel->get($id);
        if (!$InquiryAction) {
            return $this->notFount();
        }
        $data = $InquiryAction->toArray();
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

        $InquiryActionListModel = $this->getObjectManager()->get(InquiryActionListModel::class);

        $sessionManager = $this->getSessionManager();
        $sessionContainer = $sessionManager->getSession(__CLASS__);

        $paginator = $InquiryActionListModel->search($condition, $orderBy);
        $paginator->setCurrentPageNumber($page);

        $ViewModel = $this->getViewModelManager()->getViewModel([
            'viewModel' => ListViewModel::class,
            'data'      => [
                'inquiryAction' => $paginator,
                'orderBy'  => $orderBy
            ],
        ]);


        $formData = $ViewModel->getForm()->getData();
        $formData['inquiryAction'] = $condition;
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
