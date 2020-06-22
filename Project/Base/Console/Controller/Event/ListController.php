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

namespace Project\Base\Console\Controller\Event;

use Std\Controller\AbstractConsole;
use Framework\EventManager\EventManagerAwareInterface;
use Framework\EventManager\EventTargetInterface;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;

class ListController extends AbstractConsole implements
    EventManagerAwareInterface,
    ConsoleHelperAwareInterface
{
    use \Framework\EventManager\EventManagerAwareTrait;
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;

    public function index($args = null)
    {
        $composerLoader = array_filter(get_declared_classes(), function ($class) {
            return strpos($class, 'ComposerAutoloader') !== false;
        });
        $classLoader = array_shift($composerLoader)::getLoader();
        $ConsoleHelper = $this->getConsoleHelper();
        $eventTargetClasses = array_filter($classLoader->getClassMap(), function ($path, $class) {
            $path = realpath($path);
            if (strpos($path, 'vendor') === false) {
                return is_subclass_of($class, EventTargetInterface::class);
            }
            return false;
        }, ARRAY_FILTER_USE_BOTH);
        if (empty($eventTargetClasses)) {
            $ConsoleHelper->writeln('情報不足、<info> composer build </info>を先に実行してください');
            return false;
        }
        $defaultTriggers = $this->getTriggers(EventTargetInterface::class);
        foreach (array_keys($eventTargetClasses) as $eventTargetClass) {
            $triggers = array_diff($this->getTriggers($eventTargetClass), $defaultTriggers);
            if (empty($triggers)) {
                continue;
            }
            $ConsoleHelper->writeln(sprintf('<info>%-5s</info><comment>%s</comment>', $eventTargetClass, ''));
            foreach ($triggers as $trigger) {
                $ConsoleHelper->writeln(
                    sprintf('<info>%-5s</info><comment>%s</comment>', '', $trigger)
                );
            }
        }
    }

    private function getTriggers($eventTargetClass)
    {
        $reflection   = new \ReflectionClass($eventTargetClass);
        return array_keys(array_filter($reflection->getConstants(), function ($value, $constantName) {
            return strpos($constantName, 'TRIGGER_') === 0;
        }, ARRAY_FILTER_USE_BOTH));
    }

    public function getDescription()
    {
        return 'イベント一覧取得';
    }

    public function getHelp()
    {
        return <<<HELP
イベント一覧取得

example:
        php console/bin event:list
HELP;
    }
}
