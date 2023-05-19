<?php
/**
 * PHP version 7
 * File FaqTypeController.php
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
use Project\Inquiry\Api\Fieldset;
use Project\Inquiry\Admin\Controller\FaqType\ListModel as FaqTypeListModel;
use Project\Inquiry\Admin\View\ViewModel\FaqType\ListViewModel as FaqTypeListViewModel;
use Project\Viewpack\Common\Layout\EmptyLayout;
use Std\SessionManager\SessionManagerAwareInterface;

class FaqTypeController extends AbstractRestfulController implements SessionManagerAwareInterface
{
    use \Std\SessionManager\SessionManagerAwareTrait;
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

        $FaqTypeListModel = $this->getObjectManager()->get(FaqTypeListModel::class);

        $paginator = $FaqTypeListModel->search($condition, $orderBy);
        $paginator->setCurrentPageNumber($page);

        $ViewModel = $this->getViewModelManager()->getViewModel([
            'viewModel' => FaqTypeListViewModel::class,
            'data'      => [
                'faqType' => $paginator,
                'orderBy'  => $orderBy
            ],
        ]);

        $formData = $ViewModel->getForm()->getData();
        $formData['faqType'] = $condition;
        $ViewModel->getForm()->setData($formData);

        $sessionManager = $this->getSessionManager();
        $sessionContainer = $sessionManager->getSession(__CLASS__);
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
