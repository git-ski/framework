<?php
/**
 * PHP version 7
 * File CustomerListController.php
 *
 * @category Controller
 * @package  Project\Customer\Api
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Api\Controller;

use Project\Base\Api\Controller\AbstractAdminRestfulController as AbstractRestfulController;
use Project\Customer\Api\Fieldset;
use Project\Customer\Api\Controller\CustomerListModel;
use Project\Customer\Admin\Controller\Customer\ListModel;
use Project\Customer\Admin\View\ViewModel\Customer\ListViewModel;
use Project\Viewpack\Common\Layout\EmptyLayout;
use Std\SessionManager\SessionManagerAwareInterface;

class CustomerListController extends AbstractRestfulController implements SessionManagerAwareInterface
{
    use \Std\SessionManager\SessionManagerAwareTrait;

    public function getList()
    {
        $page = $this->getHttpMessageManager()->getRequest()->getQueryParams()['page'] ?? 1;
        $condition = $this->getHttpMessageManager()->getRequest()->getQueryParams()['condition'] ?? [];
        $orderBy = $this->getHttpMessageManager()->getRequest()->getQueryParams()['sort'] ?? [];

        $ListModel = $this->getObjectManager()->get(ListModel::class);

        $sessionManager = $this->getSessionManager();
        $sessionContainer = $sessionManager->getSession(__CLASS__);

        $paginator = $ListModel->search($condition, $orderBy);
        $paginator->setCurrentPageNumber($page);

        $ViewModel = $this->getViewModelManager()->getViewModel([
            'viewModel' => ListViewModel::class,
            'data'      => [
                'condition'=> $condition,
                'customer' => $paginator,
                'orderBy'  => $orderBy
            ],
        ]);

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
