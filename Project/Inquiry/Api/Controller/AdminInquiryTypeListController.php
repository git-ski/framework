<?php
/**
 * PHP version 7
 * File AdminInquiryTypeListController.php
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
use Project\Inquiry\Admin\View\ViewModel\InquiryType\ListViewModel;
use Project\Inquiry\Admin\Controller\InquiryType\ListModel as InquiryTypeListModel;
use Project\Viewpack\Common\Layout\EmptyLayout;
use Std\SessionManager\SessionManagerAwareInterface;

class AdminInquiryTypeListController extends AbstractRestfulController implements
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
        $AdminInquiryTypeListModel = $this->getObjectManager()->get(AdminInquiryTypeListModel::class);
        $InquiryType = $AdminInquiryTypeListModel->get($id);
        if (!$InquiryType) {
            return $this->notFount();
        }
        $data = $InquiryType->toArray();
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

        $InquiryTypeListModel = $this->getObjectManager()->get(InquiryTypeListModel::class);

        $sessionManager = $this->getSessionManager();
        $sessionContainer = $sessionManager->getSession(__CLASS__);

        $paginator = $InquiryTypeListModel->search($condition, $orderBy);
        $paginator->setCurrentPageNumber($page);

        $ViewModel = $this->getViewModelManager()->getViewModel([
            'viewModel' => ListViewModel::class,
            'data'      => [
                'inquiryType' => $paginator,
                'orderBy'  => $orderBy
            ],
        ]);


        $formData = $ViewModel->getForm()->getData();
        $formData['inquiryType'] = $condition;
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
