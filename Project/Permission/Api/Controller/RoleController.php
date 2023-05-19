<?php
/**
 * PHP version 7
 * File RoleController.php
 *
 * @category Controller
 * @package  Project\Permission\Api
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Permission\Api\Controller;

use Project\Base\Api\Controller\AbstractAdminRestfulController as AbstractRestfulController;
use Project\Permission\Api\Fieldset;
use Project\Permission\Api\Controller\RoleModel;
use Project\Viewpack\Common\Layout\EmptyLayout;
use Project\Permission\Admin\View\ViewModel\Role\ListViewModel;
use Project\Permission\Admin\Controller\Role\ListModel;
use Std\SessionManager\SessionManagerAwareInterface;

class RoleController extends AbstractRestfulController implements SessionManagerAwareInterface
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
                'role' => $paginator,
                'orderBy'  => $orderBy
            ],
        ]);

        $formData = $ViewModel->getForm()->getData();
        $formData['role'] = $condition;
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
