<?php
declare(strict_types=1);

namespace Project\Dev\Console\Controller\Module;

use Std\Controller\AbstractConsole;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Project\Dev\Helper\Generator\GeneratorAwareInterface;
use Project\Base\Console\Controller\Cache\CacheClearController;
use Project\Dev\Helper\DevTool\DevToolAwareInterface;

class CrudCreateController extends AbstractConsole implements
    GeneratorAwareInterface,
    ConsoleHelperAwareInterface,
    DevToolAwareInterface
{
    use \Project\Dev\Helper\Generator\GeneratorAwareTrait;
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;
    use \Project\Dev\Helper\DevTool\DevToolAwareTrait;

    public function index($args = null)
    {
        $moduleInfo                 = $this->getGenerator()->getModuleInfo();
        $moduleName                 = $this->getConsoleHelper()->ask('モジュール名');
        $moduleInfo['module']       = $moduleName;
        $moduleInfo['path'][]       = $moduleName;
        $namepace                   = $this->getConsoleHelper()->ask('サブモジュール名');
        $moduleInfo['type']         = $this->getConsoleHelper()->choice('モジュールタイプ', ['Admin', 'Front']);
        $moduleInfo['namespace']    = $namepace;
        $EntityName                 = $this->getConsoleHelper()->ask("Entity名", '入力なし、既存Entityから選択');
        if ($EntityName === '入力なし、既存Entityから選択') {
            $EntityFiles = $this->getDevTool()->getEntityFiles();
            $EntityName = $this->getConsoleHelper()->choice('Entityを選択する', array_keys($EntityFiles));
            $moduleInfo['entityPath'] = $EntityFiles[$EntityName];
        }
        $moduleInfo['entity']       = $EntityName;
        $moduleInfo['path']         = join('/', $moduleInfo['path']);
        $this->getGenerator()->setModuleInfo($moduleInfo);
        $this->getGenerator()->generateCrud();
        $moduleInfo                 = $this->getGenerator()->getModuleInfo();
        $RoutePath                  = "{$moduleInfo['path']}/{$moduleInfo['type']}/Route.php";
        // reload moduleInfo
        if (!is_file($RoutePath)) {
            $this->getGenerator()->generateRoute();
            $this->getGenerator()->flush();
        } else {
            $this->getGenerator()->flush();
            $RouteCode = $this->getGenerator()->generateRoute()->getLastTemplate();
            $this->getConsoleHelper()->writeln(["<comment>{$moduleInfo['path']}/{$moduleInfo['type']} 配下のRoute.phpに下記url設定内容を反映してください(一覧には別途apiのRoute.phpも設定する必要がある)</comment>", '']);
            $this->getConsoleHelper()->writeln([
                '<comment>',
                $RouteCode,
                '<comment>'
            ]);
        }
        $cacheClearCommand          = $this->getRouter()->findCommand(CacheClearController::class);
        $this->getConsoleHelper()->writeln("<info>use `php bin/console.php {$cacheClearCommand}` to clear routecache<info>");
    }

    public function getDescription()
    {
        return 'CRUD画面 自動生成';
    }

    public function getHelp()
    {
        return <<<HELP
Crud Generator

example:
    モジュール名? Customer\Admin
    サブモジュール名? Customer
    モジュールタイプ?
        [] Admin
        Admin
    Entity名? Customer
    （Entity入力ない場合）入力なし、既存Entityから選択
    Entityを選択する?
        [] tables
        ...
    （Entity存在しない場合Entity生成フローに入る）
        ...
HELP;
    }
}
