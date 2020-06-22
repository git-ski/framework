<?php
/**
 * PHP version 7
 * File ListController.php
 *
 * @category Controller
 * @package  Project\Base\Console
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Console\Controller\Entity;

use Std\Controller\AbstractConsole;
use Std\EntityManager\EntityManagerInterface;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;

class ListController extends AbstractConsole implements
    ConsoleHelperAwareInterface
{
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;

    public function index($args = null)
    {
        $EntityManager = $this->getObjectManager()->get(EntityManagerInterface::class);
        $generated = array_map(function ($Meta) {
            $model = str_replace('Entity', 'Model', $Meta->getName()) . 'Model';
            return [
                'table'     => $Meta->getTableName(),
                'entity'    => $Meta->getName(),
                'model'     => class_exists($model) ? $model : '',
            ];
        }, $EntityManager->getMetadataFactory()->getAllMetadata());
        $ConsoleHelper = $this->getConsoleHelper();
        foreach ($generated as ['table' => $table, 'entity' => $entity, 'model' => $model]) {
            $ConsoleHelper->writeln(sprintf('<info>%-5s</info>  ->  <comment>%s</comment>  ->  <fg=yellow;options=bold>%s</>', $table, $entity, $model));
        }
        $duplicateCheck = [];
        foreach ($generated as ['table' => $table, 'entity' => $entity]) {
            $duplicateCheck[$table] = $duplicateCheck[$table] ?? [];
            $duplicateCheck[$table][] = $entity;
        }
        $ConsoleHelper->writeln('Modelが抜けているEntity');
        foreach ($generated as ['table' => $table, 'entity' => $entity, 'model' => $model]) {
            if (!$model) {
                $ConsoleHelper->writeln(sprintf('<info>%-5s</info>  ->  <comment>%s</comment>', $table, $entity));
            }
        }
        $ConsoleHelper->writeln('重複作成されているEntity');
        foreach ($duplicateCheck as $table => $entities) {
            if (count($entities) > 1) {
                $ConsoleHelper->writeln(sprintf('<info>%-5s</info>', $table));
                foreach ($entities as $entity) {
                    $ConsoleHelper->writeln(sprintf('<comment>%s</comment>', $entity));
                }
            }
        }
    }

    public function getDescription()
    {
        return 'コマンドの簡易説明';
    }

    public function getHelp()
    {
        return <<<HELP
コマンド名

example:
        コマンドの使い方
HELP;
    }
}
