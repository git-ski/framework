<?php
/**
 * PHP version 7
 * File RepositoryManager.php
 *
 * @category Repository
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\EntityManager;

use Framework\ObjectManager\SingletonInterface;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\ObjectManager\ModuleManager;
use Laminas\Stdlib\Glob;

/**
 * Class RepositoryManager
 *
 * @category Class
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class RepositoryManager implements
    SingletonInterface,
    ObjectManagerAwareInterface
{
    use \Framework\ObjectManager\SingletonTrait;
    use \Framework\ObjectManager\ObjectManagerAwareTrait;

    private $entityPath  = [];
    private $entityFiles = null;
    private $entityClasses = null;

    /**
     * Method addEntityPath
     *
     * @param string $path Path
     *
     * @return $this
     */
    public function addEntityPath($path)
    {
        $path = realpath($path);
        $this->entityPath[$path] = $path;
        $this->entityFiles = null;
        return $this;
    }

    /**
     * Method getEntityPath
     *
     * @return array $entityPath
     */
    public function getEntityPath()
    {
        return $this->entityPath;
    }

    public function getEntityFiles()
    {
        if (null === $this->entityFiles) {
            $EntityFiles = [];
            foreach ($this->getEntityPath() as $EntityPath) {
                foreach (Glob::glob($EntityPath . '/*.php', Glob::GLOB_BRACE) as $file) {
                    $fileName = str_replace([$EntityPath, '/', '.php'], '', $file);
                    if ($fileName === 'index') {
                        continue;
                    }
                    $EntityFiles[$fileName] = $file;
                }
            }
            $this->entityFiles = $EntityFiles;
        }
        return $this->entityFiles;
    }

    public function getEntityClass()
    {
        if (null === $this->entityClasses) {
            $EntityPaths    = $this->getEntityPath();
            $EntityClasses  = [];
            $registerModule = ModuleManager::getRegisteredModules();
            [$moduleReplace, $moduleSearch] = [array_keys($registerModule), array_values($registerModule)];
            foreach ($EntityPaths as $EntityPath) {
                foreach (Glob::glob($EntityPath . '/*.php', Glob::GLOB_BRACE) as $file) {
                    if (strpos($file, 'index.php')) {
                        continue;
                    }
                    $EntityClass = str_replace($moduleSearch, $moduleReplace, $file);
                    $EntityClass = str_replace([ROOT_DIR, '/', '.php'], ['', '\\', ''], $EntityClass);
                    $EntityClasses[] = $EntityClass;
                }
            }
            $this->entityClasses = $EntityClasses;
        }
        return $this->entityClasses;
    }
}
