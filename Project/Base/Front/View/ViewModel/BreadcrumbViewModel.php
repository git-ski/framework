<?php
/**
 * PHP version 7
 * File ListViewModel.php
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;
use Std\Controller\ControllerInterface;

/**
 * Class ListViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Front
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
        $breadcrumbs    = $data['breadcrumbs'];
        $PageController = $this->getObjectManager()->get(ControllerInterface::class);
        foreach ($breadcrumbs as $index => $breadcrumbClass) {
            if ($PageController instanceof $breadcrumbClass) {
                $breadcrumbs[$index] = [
                    'href'  => false,
                    'class' => 'active',
                    'title' => $breadcrumbClass::getPageInfo()['title']
                ];
            } else {
                $breadcrumbs[$index] = [
                    'href'  => $this->getRouter()->linkto($breadcrumbClass),
                    'class' => null,
                    'title' => $breadcrumbClass::getPageInfo()['title']
                ];
            }
        }
        $data['breadcrumbs'] = $breadcrumbs;
        $this->setData($data);
    }

    public function getTemplateDir(): string
    {
        return __DIR__ . '/..';
    }
}
