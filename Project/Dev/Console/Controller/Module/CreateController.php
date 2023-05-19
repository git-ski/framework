<?php
declare(strict_types=1);

namespace Project\Dev\Console\Controller\Module;

use Std\Controller\AbstractConsole;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Project\Dev\Helper\Generator\GeneratorAwareInterface;
class CreateController extends AbstractConsole implements
    GeneratorAwareInterface,
    ConsoleHelperAwareInterface
{
    use \Project\Dev\Helper\Generator\GeneratorAwareTrait;
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;

    public function index($args = null)
    {
        $moduleInfo                 = $this->getGenerator()->getModuleInfo();
        $moduleName                 = $this->getConsoleHelper()->ask('Input Module');
        $moduleInfo['module']       = $moduleName;
        $moduleInfo['namespace']    = '\\' . $moduleName;
        $moduleInfo['path'][]       = $moduleName;
        $moduleInfo['path']         = join('/', $moduleInfo['path']);
        $className                  = $this->getConsoleHelper()->ask('Input Class Name');
        $moduleInfo['class']        = $className;
        // $moduleType                 = $this->getConsoleHelper()->choice('Input Module Type', ['Service', 'Manager']);
        $moduleType                 = $this->getConsoleHelper()->choice('Input Module Type', ['Service']);
        $moduleInfo['moduleType']   = $moduleType;
        $this->getGenerator()->setModuleInfo($moduleInfo);
        $this->getGenerator()->generateModule()->flush();
    }

    public function getDescription()
    {
        return 'モジュールひな型 自動生成';
    }

    public function getHelp()
    {
        return <<<HELP
Module Generator

example:
    Input Module? Std\LoggerService
    Input Class Name? LoggerService
    Input Module Type>
      [0]Service
      [1]Manager
    >Service
HELP;
    }
}
