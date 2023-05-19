<?php
declare(strict_types=1);

namespace Project\Dev\Console\Controller\Module;

use Std\Controller\AbstractConsole;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Project\Dev\Helper\Generator\GeneratorAwareInterface;
use Project\Dev\Helper\DevTool\DevToolAwareInterface;

class ConsoleCreateController extends AbstractConsole implements
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
        $moduleInfo['namespace']    = $this->getConsoleHelper()->ask('サブモジュール名');
        $moduleInfo['controller']   = $this->getConsoleHelper()->ask('コントローラ名');
        $moduleInfo['controller']   = preg_replace('/Controller$/', '', $moduleInfo['controller']) . 'Controller';
        $moduleInfo['app']          = $this->getConsoleHelper()->ask('コマンドを教えてください');
        $moduleInfo['path']         = join('/', $moduleInfo['path']);
        $moduleInfo['type']         = 'Console';

        $moduleInfo['Controllers'][$moduleInfo['app']] = 'Controller\\' . $moduleInfo['namespace'] . '\\' . $moduleInfo['controller'];

        $this->getGenerator()->setModuleInfo($moduleInfo);
        $this->getGenerator()->generateConsole();
        $moduleInfo = $this->getGenerator()->getModuleInfo();
        $RoutePath                  = "{$moduleInfo['path']}/{$moduleInfo['type']}/Command.php";
        // reload moduleInfo
        if (!is_file($RoutePath)) {
            $this->getGenerator()->generateCommand();
            $this->getGenerator()->flush();
        } else {
            $this->getGenerator()->flush();
            $RouteCode = $this->getGenerator()->generateCommand()->getLastTemplate();
            $this->getConsoleHelper()->writeln(["<comment>{$moduleInfo['path']}/{$moduleInfo['type']} 配下のCommand.phpに下記url設定内容を反映してください</comment>", '']);
            $this->getConsoleHelper()->writeln([
                '<comment>',
                $RouteCode,
                '<comment>'
            ]);
        }

    }

    public function getDescription()
    {
        return 'コンソールコマンド 自動生成';
    }

    public function getHelp()
    {
        return <<<HELP
Controller Generator

example:
    Input Module? EC\Admin
    Input Namespace? Product
    Input Module Type?[Admin/Front/Console]? Admin
    Input Controller? RegisterController
HELP;
    }
}
