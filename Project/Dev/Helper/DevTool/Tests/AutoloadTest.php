<?php
/**
 * PHP version 7
 * File AutoloadTest.php
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);
namespace Project\Dev\Helper\DevTool\Tests;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Project\Dev\Helper\DevTool\DevToolInterface;
use Project\Dev\Helper\DevTool\DevToolAwareInterface;
use Project\Dev\Helper\DevTool\DevToolAwareTrait;
use Project\Dev\Helper\DevTool\DevTool;

/**
 * Class AutoloadTest
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
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
        $this->assertTrue(interface_exists(DevToolInterface::class));
        $this->assertTrue(interface_exists(DevToolAwareInterface::class));
        // class
        $this->assertTrue(class_exists(DevTool::class));
        // trait
        $this->assertTrue(trait_exists(DevToolAwareTrait::class));
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
        $DevTool = $ObjectManager->create(
            DevToolInterface::class,
            DevTool::class
        );
        $this->assertInstanceOf(DevToolInterface::class, $DevTool);
    }
}
