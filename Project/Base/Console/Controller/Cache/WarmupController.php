<?php
declare(strict_types=1);

namespace Project\Base\Console\Controller\Cache;

use Std\Controller\AbstractConsole;
use Std\EntityManager\EntityManagerInterface;
use Std\EntityManager\EntityInterface;
use Std\EntityManager\AbstractEntity;
use Std\RouterManager\Http\Router as HttpRouter;
use Framework\EventManager\EventManagerInterface;

class WarmupController extends AbstractConsole
{

    public function index()
    {
        $CacheModel = $this->getObjectManager()->get(CacheModel::class);
        $CacheModel->warmUpTranslator();
        echo 'Translator Cache warmed', PHP_EOL;
        $CacheModel->warmUpEntity();
        echo 'Entity Cache warmed', PHP_EOL;
        $CacheModel->warmUpRouter();
        echo 'Router Cache warmed', PHP_EOL;
        $CacheModel->warmUpEvent();
        echo 'Event Cache warmed', PHP_EOL;
        $CacheModel->warmUpOpcache();
        echo 'OpCache warmed', PHP_EOL;
    }

    public function getDescription()
    {
        return 'cache clear';
    }

    public function getHelp()
    {
       return <<<HELP
Help
Usage:
    php bin/console.php cache::warmup
HELP;
    }
}
