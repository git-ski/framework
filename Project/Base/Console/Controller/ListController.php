<?php
declare(strict_types=1);

namespace Project\Base\Console\Controller;

use Std\Controller\AbstractConsole;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;

class ListController extends AbstractConsole implements
    ConsoleHelperAwareInterface
{
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;

    public function index()
    {
        $routerList     = $this->getRouter()->getRouterList();
        $ObjectManager  = $this->getObjectManager();
        $commands       = [];
        $cmdGroups      = [];
        foreach ($routerList as $cmd => $console) {
            $Console        = $console::getSingleton(); //$ObjectManager->create($console);
            if (empty($Console)) {
                $this->getConsoleHelper()->writeln([
                    "<error>",
                    "found invalid command: {$cmd}",
                    "</error>"
                ]);
                continue;
            }
            $tokens         = explode(':', $cmd);
            $group              = $tokens[0];
            $cmdGroups[$group]  = $cmdGroups[$group] ?? [];
            $cmdGroups[$group][] = [
                'cmd'           => $cmd,
                'description'   => $Console->getDescription(),
                'priority'      => $Console->getPriority()
            ];
        }
        $this->getConsoleHelper()->writeln("<comment>Available commands:</comment>");
        $this->outputCommands($commands);
        //sort commands
        foreach ($cmdGroups as $group => $commands) {
            $this->getConsoleHelper()->writeln(" <comment>{$group}</comment>");
            $this->outputCommands($commands);
        }
    }

    private function outputCommands($commands)
    {
        usort($commands, function ($cmd1, $cmd2) {
            return strnatcmp($cmd1['cmd'], $cmd2['cmd']);
        });
        //
        foreach ($commands as $command) {
            extract($command);
            $this->getConsoleHelper()->writeln(sprintf('  <info>%-40s</info> %s', $cmd, $description));
        }
    }

    public function getDescription()
    {
        return 'list all commands';
    }

    public function getHelp()
    {
        return <<<HELP
List All Command
Usage:
    php bin/console.php list
HELP;
    }

    public function getPriority()
    {
        return 0;
    }
}
