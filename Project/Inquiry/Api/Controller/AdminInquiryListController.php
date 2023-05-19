<?php
/**
 * PHP version 7
 * File AdminInquiryListController.php
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
use Project\Inquiry\Admin\View\ViewModel\Inquiry\ListViewModel;
use Project\Inquiry\Admin\Controller\Inquiry\ListModel as InquiryListModel;
use Project\Viewpack\Common\Layout\EmptyLayout;
use Std\SessionManager\SessionManagerAwareInterface;

class AdminInquiryListController extends AbstractRestfulController implements
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
        $AdminInquiryListModel = $this->getObjectManager()->get(AdminInquiryListModel::class);
        $Inquiry = $AdminInquiryListModel->get($id);
        if (!$Inquiry) {
            return $this->notFount();
        }
        $data = $Inquiry->toArray();
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

        $InquiryListModel = $this->getObjectManager()->get(InquiryListModel::class);

        $sessionManager = $this->getSessionManager();
        $sessionContainer = $sessionManager->getSession(__CLASS__);

        $paginator = $InquiryListModel->search($condition, $orderBy);
        $paginator->setCurrentPageNumber($page);

        $ViewModel = $this->getViewModelManager()->getViewModel([
            'viewModel' => ListViewModel::class,
            'data'      => [
                'inquiry' => $paginator,
                'orderBy'  => $orderBy
            ],
        ]);


        $formData = $ViewModel->getForm()->getData();
        $formData['inquiry'] = $condition;
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
