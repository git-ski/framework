<?php
declare(strict_types=1);

namespace Project\Base\Console\Controller\Cache;

use Std\Controller\AbstractConsole;
use Std\CacheManager\CacheManagerAwareInterface;

class CacheClearController extends AbstractConsole implements
    CacheManagerAwareInterface
{
    use \Std\CacheManager\CacheManagerAwareTrait;

    public function index()
    {
        $this->getCacheManager()->flushAll();
        echo 'cache clear successsed!', PHP_EOL;
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
    php bin/console.php cache::clear::all
HELP;
    }
}
