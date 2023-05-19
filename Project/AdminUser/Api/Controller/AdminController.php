<?php
/**
 * PHP version 7
 * File AdminController.php
 *
 * @category Controller
 * @package  Project\AdminUser\Api
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\AdminUser\Api\Controller;

use Project\Base\Api\Controller\AbstractAdminRestfulController as AbstractRestfulController;
use Project\AdminUser\Api\Fieldset;
use Project\AdminUser\Api\Controller\AdminModel;
use Project\AdminUser\Admin\View\ViewModel\AdminUser\ListViewModel;
use Project\AdminUser\Admin\Controller\AdminUser\ListModel;
use Project\Viewpack\Common\Layout\EmptyLayout;
use Std\SessionManager\SessionManagerAwareInterface;

class AdminController extends AbstractRestfulController implements SessionManagerAwareInterface
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

        $ListModel = $this->getObjectManager()->get(ListModel::class);
        $paginator = $ListModel->search($condition, $orderBy);
        $paginator->setCurrentPageNumber($page);

        $ViewModel = $this->getViewModelManager()->getViewModel([
            'viewModel' => ListViewModel::class,
            'data'      => [
                'admin' => $paginator,
                'orderBy'  => $orderBy
            ],
        ]);

        $formData = $ViewModel->getForm()->getData();
        $formData['admin'] = $condition;
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
