<?php
declare(strict_types=1);

namespace Project\Dev\Console\Controller\Module;

use Std\Controller\AbstractConsole;
use Std\Controller\AbstractController;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Project\Dev\Helper\Generator\GeneratorAwareInterface;
use Project\Dev\Helper\Generator\Handler\Entity;

class EntityCreateController extends AbstractConsole implements
    GeneratorAwareInterface,
    ConsoleHelperAwareInterface
{
    use \Project\Dev\Helper\Generator\GeneratorAwareTrait;
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;

    public function index($args = null)
    {
        $moduleInfo                 = $this->getGenerator()->getModuleInfo();
        $moduleName                 = $this->getConsoleHelper()->ask('モジュール名');
        $moduleInfo['module']       = $moduleName;
        $moduleInfo['namespace']    = '\\' . $moduleName;
        $moduleInfo['path'][]       = $moduleName;
        $EntityHandler              = $this->getGenerator()->getHandler(Entity::class);
        $tables                     = $EntityHandler->getTables();
        $tableName                  = $this->getConsoleHelper()->choice("どのテーブルのEntityを生成", $tables);
        if (empty($tableName)) {
            die;
        }
        $moduleInfo['table']        = $tableName;
        $suggest                    = $EntityHandler->suggestConvert($tableName);
        if ($suggest) {
            $EntityName                 = $this->getConsoleHelper()->ask("Entity名[{$suggest}] ", $suggest);
        } else {
            $EntityName                 = $this->getConsoleHelper()->ask("Entity名");
        }
        $moduleInfo['entity']       = $EntityName;
        $moduleInfo['path']         = join('/', $moduleInfo['path']);
        $this->getGenerator()->setModuleInfo($moduleInfo);
        $this->getGenerator()->generateEntity()->flush();
    }

    public function getDescription()
    {
        return 'Entity 自動生成';
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
