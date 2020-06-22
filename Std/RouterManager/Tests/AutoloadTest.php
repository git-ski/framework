<?php
/**
 * PHP version 7
 * File AutoloadTest.php
 *
 * @category UnitTest
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\RouterManager\Tests;

use PHPUnit\Framework\TestCase;
use Std\RouterManager;
use Framework\ObjectManager\ObjectManager;

/**
 * Class AutoloadTest
 *
 * @category UnitTest
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class AutoloadTest extends TestCase
{
    /**
     * Method testAutoload
     *
     * @return  null
     * @example
     * @since
     */
    public function testAutoload()
    {
        // interface
        $this->assertTrue(interface_exists(RouterManager\RouterInterface::class));
        $this->assertTrue(interface_exists(RouterManager\RouterManagerInterface::class));
        $this->assertTrue(interface_exists(RouterManager\RouterManagerAwareInterface::class));
        // class
        $this->assertTrue(class_exists(RouterManager\AbstractRouter::class));
        $this->assertTrue(class_exists(RouterManager\Http\Router::class));
        $this->assertTrue(class_exists(RouterManager\Console\Router::class));
        $this->assertTrue(class_exists(RouterManager\RouterManager::class));
        // trait
        $this->assertTrue(trait_exists(RouterManager\RouterManagerAwareTrait::class));
    }

    /**
     * Method testInstance
     *
     * @return  null
     * @example
     * @since
     */
    public function testInstance()
    {
        $ObjectManager = ObjectManager::getSingleton();
        $RouterManager = $ObjectManager->create(
            RouterManager\RouterManagerInterface::class,
            RouterManager\RouterManager::class
        );
        $this->assertInstanceOf(RouterManager\RouterManagerInterface::class, $RouterManager);
        $HttpRouter = $ObjectManager->create(
            RouterManager\RouterInterface::class,
            RouterManager\Http\Router::class
        );
        $this->assertInstanceOf(RouterManager\RouterInterface::class, $HttpRouter);
        $ConsoleRouter = $ObjectManager->create(
            RouterManager\RouterInterface::class,
            RouterManager\Console\Router::class
        );
        $this->assertInstanceOf(RouterManager\RouterInterface::class, $ConsoleRouter);
    }
}
