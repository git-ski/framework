<?php
declare(strict_types=1);

namespace Project\Base\Admin\View\ViewModel;

use Std\ViewModel\AbstractViewModel;
use Framework\ObjectManager\ObjectManager;
use Std\RouterManager\RouterManagerInterface;
use Project\Base\Admin\Controller\AbstractAdminController;

class SidemenuViewModel extends AbstractViewModel
{
    const LEFT_TOP    = 'LeftTop';
    const LEFT_BOTTOM = 'LeftBottom';

    protected $template = '/template/sidemenu.twig';
    protected $data = null;
    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
    ];

    public function onRender()
    {
        $Router = $this->getRouterManager()->getMatched();
        $routerList = $Router->getRouterList();
        $data = $menuList = [];
        foreach ($routerList as $url => $controller) {
            if (!is_subclass_of($controller, AbstractAdminController::class)) {
                continue;
            }
            $pageInfo = $controller::getPageInfo();
            if (!$pageInfo['menu']) {
                continue;
            }
            $menuList[] = [
                'url'        => $url,
                'controller' => $controller,
                'pageInfo'   => $pageInfo,
                'priority'   => isset($pageInfo['priority']) ? $pageInfo['priority'] : 99,
            ];
        }
        usort($menuList, function ($item1, $item2) {
            return $item1['priority'] > $item2['priority'] ? 1 : -1;
        });
        foreach ($menuList as [
                'url' => $url,
                'controller' => $controller,
                'pageInfo'   => $pageInfo,
                'priority'   => $priority,
            ]) {
            $controllerData = [
                'title' => $pageInfo['description'],
                'link' => '/' . $url,
                'priority' => $priority,
                'icon' => $pageInfo['icon'] ?? substr($pageInfo['description'], 0, 1),
            ];
            if (isset($pageInfo['group'])) {
                $group = $pageInfo['group'];
                if (!isset($data[$group])) {
                    $data[$group] = [
                        'title' => $group,
                        'link' => 'javascript::void(0)',
                        'child' => [],
                        'priority' => $priority,
                        'icon' => $pageInfo['groupIcon'] ?? substr($pageInfo['description'], 0, 1),
                    ];
                }
                $data[$group]['child'][$controller] = $controllerData;
            } else {
                $data[$controller] = $controllerData;
            }
        }
        $this->setData($data);
    }

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
