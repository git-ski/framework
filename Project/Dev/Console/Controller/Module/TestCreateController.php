<?php
declare(strict_types=1);

namespace Project\Dev\Console\Controller\Module;

use Std\Controller\AbstractConsole;
use Std\Controller\AbstractController;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Project\Dev\Helper\Generator\GeneratorAwareInterface;

class TestCreateController extends AbstractConsole implements
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
        $this->getGenerator()->setModuleInfo($moduleInfo);
        $this->getGenerator()->generateTest()->flush();
    }

    public function getDescription()
    {
        return 'UnitTestひな型 自動生成';
    }

    public function getHelp()
    {
        return <<<HELP
Entity Generator

example:
    Input Module? Cms\Admin
    Input Table Name? blogs
HELP;
    }
}
