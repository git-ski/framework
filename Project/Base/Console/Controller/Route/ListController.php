<?php
declare(strict_types=1);

/**
 * Webアプリのルータ一覧を取得して表示する
 */
namespace Project\Base\Console\Controller\Route;

use Std\Controller\AbstractConsole;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Std\RouterManager\RouterManagerInterface;
use Std\RouterManager\RouterManager;
use Std\RouterManager\Http\Router;
use Project\Base\Admin\Controller\AbstractAdminController;
use Project\Base\Front\Controller\AbstractController;
use Project\Base\Api\Controller\AbstractRestfulController;
use Project\Base\Api\Controller\AbstractAdminRestfulController;


class ListController extends AbstractConsole implements
    ConsoleHelperAwareInterface
{
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;

    public function index()
    {
        $ObjectManager     = $this->getObjectManager();
        // webのアプリルータ情報を取得するには、http用のルータを生成する。
        $HttpRouter        = $ObjectManager->create(Router::class);
        $routerList     = $HttpRouter->getRouterList();
        $applications   = [];
        $notExists      = [];
        foreach ($routerList as $app => $controller) {
            if (!class_exists($controller)) {
                $notExists[$app] = $controller;
                continue;
            }
            $Controller        = $controller::getSingleton(); //$ObjectManager->create($controller);
            if (empty($Controller)) {
                $this->getConsoleHelper()->writeln([
                    "<error>found invalid app: {$app}</error>"
                ]);
                continue;
            }
            $applications[$app] = [
                'app'           => $app,
                'description'   => $Controller->getDescription(),
                'controller'    => $controller,
                'group'         => $this->getGroup($Controller)
            ];
        }
        $ConsoleHelper = $this->getConsoleHelper();
        $ConsoleHelper->writeln(sprintf('%-60s | %-60s |  %-10s | %s', 'URL', 'Controller', 'グループ', '画面情報'));
        foreach ($applications as $application) {
            extract($application);
            $ConsoleHelper->writeln(
                sprintf(
                    '<info>%-60s</info> | <comment>%-60s</comment> | %-10s | %s',
                    $app,
                    $controller,
                    $group,
                    $description
                )
            );
        }
        $ConsoleHelper->writeln('存在しない画面');
        foreach ($notExists as $app => $controller) {
            $ConsoleHelper->writeln(
                sprintf(
                    '<info>%-50s</info> | <comment>%-60s</comment>',
                    $app,
                    $controller
                )
            );
        }
    }

    private function getGroup($Controller)
    {
        switch(true) {
            case $Controller instanceof AbstractAdminController:
                return 'Admin';
                break;
            case $Controller instanceof AbstractAdminRestfulController:
                return 'Admin Api';
                break;
            case $Controller instanceof AbstractController:
                return 'Front';
                break;
            case $Controller instanceof AbstractRestfulController:
                return 'Front Api';
                break;
        }
    }

    public function getDescription()
    {
        return 'list all application';
    }

    public function getHelp()
    {
        return <<<HELP
List All Web Application
Usage:
    php bin/console.php route::list
HELP;
    }

    public function getPriority()
    {
        return 0;
    }
}
