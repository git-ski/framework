<?php
/**
 * PHP version 7
 * File Project\Dev\Helper\DevTool.php
 *
 * @category DevTool
 * @package  Project\Dev\Helper\DevTool
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Dev\Helper\DevTool;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\EntityManager\RepositoryManager;
use Laminas\Stdlib\Glob;

/**
 * Class DevTool
 *
 * @category DevTool
 * @package  Project\Dev\Helper\DevTool
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class DevTool implements
    DevToolInterface,
    ObjectManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;

    public function getEntityFiles()
    {
        $EntityPaths = $this->getObjectManager()->get(RepositoryManager::class)->getEntityPath();
        $EntityFiles = [];
        foreach ($EntityPaths as $EntityPath) {
            foreach (Glob::glob($EntityPath . '/*.php', Glob::GLOB_BRACE) as $file) {
                $fileName = str_replace([$EntityPath, '/', '.php'], '', $file);
                if ($fileName === 'index') {
                    continue;
                }
                $EntityFiles[$fileName] = $file;
            }
        }
        return $EntityFiles;
    }

    public function getModules($scope = 'Project')
    {
        $scope = ROOT_DIR . $scope;
        $modules = [];
        foreach (Glob::glob($scope . '/*', Glob::GLOB_ONLYDIR) as $dir) {
            $module = str_replace([
                ROOT_DIR, '/'
            ], ['', '\\'], $dir);
            $modules[] = $module;
        }
        return $modules;
    }
}
