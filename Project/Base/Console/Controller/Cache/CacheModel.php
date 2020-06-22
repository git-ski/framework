<?php
declare(strict_types=1);

namespace Project\Base\Console\Controller\Cache;

use Framework\EventManager\EventManagerInterface;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\Controller\AbstractConsole;
use Std\EntityManager\EntityManagerInterface;
use Std\EntityManager\EntityInterface;
use Std\EntityManager\AbstractEntity;
use Std\RouterManager\Http\Router as HttpRouter;
use Std\TranslatorManager\TranslatorManagerInterface;

class CacheModel implements ObjectManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;

    public function warmUpOpcache()
    {
        opcache_reset();
        foreach ($this->getClasses() as $class => $file) {
            // if (strpos($file, 'vendor') === false) {
            $file = realpath($file);
            if (opcache_is_script_cached($file)) continue;
            @opcache_compile_file($file);
            // }
        }
    }

    public function warmUpEntity()
    {
        // Entity
        $EntityManager  = $this->getObjectManager()->get(EntityManagerInterface::class);
        $EntityClasses = array_filter($this->getClasses(), function ($path, $class) {
            $path = realpath($path);
            if (strpos($path, 'vendor') === false) {
                return is_subclass_of($class, EntityInterface::class) && $class !== AbstractEntity::class;
            }
            return false;
        }, ARRAY_FILTER_USE_BOTH);
        foreach (array_keys($EntityClasses) as $EntityClass) {
            $Entity = new $EntityClass;
            $Entity->toArray();
        }
    }

    public function warmUpRouter()
    {
        // Router
        $HttpRouter     = $this->getObjectManager()->get(HttpRouter::class);
        $HttpRouter->getRouterList();
    }

    public function warmUpEvent()
    {
        // Event
        $EventManager   = $this->getObjectManager()->get(EventManagerInterface::class);
        $eventTargetClasses = array_filter($this->getClasses(), function ($path, $class) {
            $path = realpath($path);
            if (strpos($path, 'vendor') === false) {
                return is_subclass_of($class, EventTargetInterface::class);
            }
            return false;
        }, ARRAY_FILTER_USE_BOTH);
        foreach (array_keys($eventTargetClasses) as $eventTargetClass) {
            $EventManager->initTrigger($eventTargetClass);
        }
    }

    public function warmUpTranslator()
    {
        $Translators = $this->getObjectManager()->get(TranslatorManagerInterface::class)->getTranslators();
        foreach ($Translators as $Translator) {
            $Translator->getAllMessages();
        }
    }

    private function getClasses()
    {
        // class loader
        $composerLoader = array_filter(get_declared_classes(), function ($class) {
            return strpos($class, 'ComposerAutoloader') !== false;
        });
        $classLoader = array_shift($composerLoader)::getLoader();
        return $classLoader->getClassMap();
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
