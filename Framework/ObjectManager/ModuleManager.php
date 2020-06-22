<?php
/**
 * PHP version 7
 * File ObjectManager.php
 *
 * @category Class
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\ObjectManager;

/**
 * Class ObjectManager
 *
 * @category Class
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class ModuleManager
{
    private static $modules = [];
    private static $exports = [];
    private static $inits   = [];

    public static function register($module, $namespace)
    {
        self::$modules[$namespace] = $module;
    }

    public static function getRegisteredModules()
    {
        return self::$modules;
    }

    public static function init()
    {
        // @codeCoverageIgnoreStart
        self::prepareGlobalExport();
        self::prepareModuleExport();
        self::prepareGlobalInit();
        self::prepareModuleInit();
        self::process();
        // @codeCoverageIgnoreEnd
    }
    /**
     * Method exportGlobalObject
     *
     * @return void
     */
    private static function prepareGlobalExport()
    {
        foreach (glob(ROOT_DIR . 'Framework/*/export.php') as $objectExporter) {
            self::$exports[$objectExporter] = true;
        }
        foreach (glob(ROOT_DIR . 'Std/*/export.php') as $objectExporter) {
            self::$exports[$objectExporter] = true;
        }
    }

    /**
     * Method exportModuleObject
     *
     * @return void
     */
    private static function prepareModuleExport()
    {
        foreach (self::$modules as $module) {
            foreach (glob($module . '/*/export.php') as $moduleExporter) {
                self::$exports[$moduleExporter] = true;
            }
        }
        foreach (glob(ROOT_DIR . 'Project/*/*/export.php') as $moduleExporter) {
            self::$exports[$moduleExporter] = true;
        }
    }

    /**
     * Method initGlobalObject
     *
     * @return void
     */
    private static function prepareGlobalInit()
    {
        foreach (glob(ROOT_DIR . 'Framework/*/index.php') as $ObjectEntry) {
            self::$inits[$ObjectEntry] = true;
        }
        foreach (glob(ROOT_DIR . 'Std/*/index.php') as $ObjectEntry) {
            self::$inits[$ObjectEntry] = true;
        }
    }

    /**
     * Method initModuleObject
     *
     * @return void
     */
    private static function prepareModuleInit()
    {
        foreach (self::$modules as $module) {
            foreach (glob($module . '/*/index.php') as $moduleEntry) {
                self::$inits[$moduleEntry] = true;
            }
        }
        foreach (glob(ROOT_DIR . 'Project/*/*/index.php') as $moduleEntry) {
            self::$inits[$moduleEntry] = true;
        }
    }

    private static function process()
    {
        foreach (self::$exports as $exports => $dummy) {
            include $exports;
        }
        foreach (self::$inits as $inits => $dummy) {
            include $inits;
        }
    }
}
