<?php
declare(strict_types=1);

namespace Project\Base\Console\Controller;

use Std\Controller\AbstractConsole;
use Laminas\EventManager\EventManagerAwareInterface;
use Std\RouterManager\RouterManagerAwareInterface;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;

class HelpController extends AbstractConsole implements
    RouterManagerAwareInterface,
    ConsoleHelperAwareInterface
{
    use \Std\RouterManager\RouterManagerAwareTrait;
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;

    public function index($consoles)
    {
        if (empty($consoles)) {
            $consoles = ['help'];
        }
        $consoles       = array_unique($consoles);
        $routerList     = $this->getRouterManager()->getMatched()->getRouterList();
        $ObjectManager  = $this->getObjectManager();
        foreach ($consoles as $index => $console) {
            $this->getConsoleHelper()->writeln(
                '<comment>---------------------------------------------------------</comment>'
            );
            if (isset($routerList[$console])) {
                $Console = $ObjectManager->create($routerList[$console]);
                $help    = $Console->getHelp();
            } else {
                $help   = $console . PHP_EOL;
                $help  .= sprintf('%20s', 'invalid Command');
            }
            $this->getConsoleHelper()->writeln(['<comment>', $help, PHP_EOL, '</comment>']);
        }
    }

    public function getDescription()
    {
        return 'see help for command';
    }

    public function getHelp()
    {
        return <<<HELP
Help
Usage:
    php bin/console.php <command> [<args>...]

Some commands
    list                            List All Command
    help                            See Help for Command
    cngo::module::create            module generator

See 'php bin/console.php help <command>' for more information on a specific command.
HELP;
    }

    public function getPriority()
    {
        return 1;
    }
}
