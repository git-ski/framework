<?php
declare(strict_types=1);

namespace Project\Dev\Console\Controller\Model;

use Std\Controller\AbstractConsole;
use Std\EntityManager\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Std\EntityManager\EntityManagerAwareInterface;

class DoctrineController extends AbstractConsole implements EntityManagerAwareInterface
{
    use \Std\EntityManager\EntityManagerAwareTrait;

    public function index()
    {
        // cut off the noisy argument
        unset($_SERVER['argv'][1]);
        $_SERVER['argv'] = array_values($_SERVER['argv']);
        // migration from doctrine-command
        $EntityManager = $this->getEntityManager();
        ConsoleRunner::run(ConsoleRunner::createHelperSet($EntityManager));
    }

    public function getDescription()
    {
        return 'Doctrineコマンド転送';
    }

    public function getHelp()
    {
        return <<<HELP
Help
Usage:
    php bin/console.php doctrine [<args>...]

generate-entities, etc.:
    php bin/console.php doctrine orm:convert-mapping --namespace="NAMESPACE\\" --force --from-database annotation ./
    php bin/console.php doctrine orm:generate-entities ./ --generate-annotations=true
HELP;
    }
}
