<?php
declare(strict_types=1);

namespace Project\Dev\Console\Controller\Model;

use Std\Controller\AbstractConsole;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Project\Dev\Helper\Generator\GeneratorAwareInterface;
use Project\Dev\Helper\DevTool\DevToolAwareInterface;
use Project\Dev\Helper\Generator\Handler\Entity;

class EntityI18nAssistantController extends AbstractConsole implements
    ConsoleHelperAwareInterface,
    GeneratorAwareInterface,
    DevToolAwareInterface
{
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;
    use \Project\Dev\Helper\Generator\GeneratorAwareTrait;
    use \Project\Dev\Helper\DevTool\DevToolAwareTrait;

    public function index()
    {
        $EntityFiles    = $this->getDevTool()->getEntityFiles();
        $Entity         = $this->getConsoleHelper()->choice('Entityを選択する', array_keys($EntityFiles));
        $EntityFile     = $EntityFiles[$Entity];
        $moduleInfo     = $this->getGenerator()->parseEntityForFieldset(file_get_contents($EntityFile));
        $propertyList   = $moduleInfo['EntityPropertyList'];
        $Entity         = strtoupper($Entity);
        // まずはプロパティー
        foreach ($propertyList as $name => $property) {
            $Name = strtoupper($name);
            $this->getConsoleHelper()->writeln("<info>'{$Entity}_{$Name}' => '',</info>");
        }

        // そして、type/flagなどのvalueoption
        if ($EntityModel = $this->getGenerator()->getHandler(Entity::class)->getEntityModel($EntityFile)) {
            $valueOptions = $EntityModel->getValueOptions();
        } else {
            $valueOptions = [];
            foreach ($propertyList as $name => $property) {
                if ($property['type'] === 'checkbox') {
                    $Category = strtoupper($property['category']);
                    $valueOptions[] = [
                        '{$Entity}_{$Name}_ON',
                        '{$Entity}_{$Name}_OFF'
                    ];
                }
            }
        }
        foreach ($valueOptions as $valueOption) {
            foreach ($valueOption as $option) {
                $this->getConsoleHelper()->writeln("<info>'{$option}' => '',</info>");
            }
        }
    }

    public function getDescription()
    {
        return 'Entity 多言語アシスタント';
    }

    public function getHelp()
    {
       return <<<HELP
Help
Usage:
    php bin/console.php dev:entity:i18n:assistant
HELP;
    }
}
