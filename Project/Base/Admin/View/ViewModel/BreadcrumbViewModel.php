<?php
/**
 * PHP version 7
 * File ListViewModel.php
 *
 * @category ViewModel
 * @package  Project\Customer\Admin
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Admin\View\ViewModel;

use Std\ViewModel\AbstractViewModel;
use Std\Controller\ControllerInterface;

/**
 * Class ListViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Admin
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class BreadcrumbViewModel extends AbstractViewModel
{
    protected $template = "/template/breadcrumb.twig";

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
    ];

    public function onRender(): void
    {
        $data           = $this->getData();
        $breadcrumbs    = [];
        $PageController = $this->getObjectManager()->get(ControllerInterface::class);
        $PageInfo = $PageController::getPageInfo();
        $breadcrumbs[] = [
            'href'  => false,
            'class' => '',
            'title' => $PageInfo['group'] ?? ''
        ];
        $breadcrumbs[] = [
            'href'  => $this->getRouter()->linkto(get_class($PageController)),
            'class' => 'active',
            'title' => $PageInfo['description']
        ];
        $data['breadcrumbs'] = $breadcrumbs;
        $this->setData($data);
    }

    public function getTemplateDir(): string
    {
        return __DIR__ . '/..';
    }
}
