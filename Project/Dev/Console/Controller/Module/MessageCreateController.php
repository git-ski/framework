<?php
declare(strict_types=1);

namespace Project\Dev\Console\Controller\Module;

use Std\Controller\AbstractConsole;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Project\Dev\Helper\Generator\GeneratorAwareInterface;
use Project\Base\Console\Controller\Cache\CacheClearController;
use Project\Dev\Helper\DevTool\DevToolAwareInterface;

class MessageCreateController extends AbstractConsole implements
    GeneratorAwareInterface,
    ConsoleHelperAwareInterface,
    DevToolAwareInterface
{
    use \Project\Dev\Helper\Generator\GeneratorAwareTrait;
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;
    use \Project\Dev\Helper\DevTool\DevToolAwareTrait;

    public function index($args = null)
    {
        $moduleInfo             = $this->getGenerator()->getModuleInfo();
        $moduleName             = $this->getConsoleHelper()->ask('モジュール名');
        $moduleInfo['module']   = $moduleName;
        $moduleInfo['path'][]   = $moduleName;
        $namepace               = $this->getConsoleHelper()->ask('サブモジュール名');
        $moduleInfo['namespace']= $namepace;
        $moduleInfo['type']     = $this->getConsoleHelper()->choice('モジュールタイプ', ['Admin', 'Front']);
        $moduleInfo['viewType'] = 'Message';
        $moduleInfo['path']     = join('/', $moduleInfo['path']);
        $this->getGenerator()->setModuleInfo($moduleInfo);
        $this->getGenerator()->generateView()->flush();
    }

    public function getDescription()
    {
        return 'メールメッセージ 自動生成';
    }

    public function getHelp()
    {
        return <<<HELP
Message Generator

example:
    モジュール名? Project\AdminUser
    サブモジュール名? AdminUser
    モジュールタイプ?
        [] Admin
        [] Front
        Admin
    送信処理をキャメルケースで入力してください[register]? edit
HELP;
    }
}
