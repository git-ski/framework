<?php
/**
 * PHP version 7
 * File AutoloadTest.php
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\HttpMessageManager\Tests;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;

/**
 * Class AutoloadTest
 *
 * @category UnitTest
 * @package  Framework\MailerService
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
        $this->assertTrue(interface_exists(\Std\HttpMessageManager\HttpMessageManagerInterface::class));
        $this->assertTrue(interface_exists(\Std\HttpMessageManager\HttpMessageManagerAwareInterface::class));
        // class
        $this->assertTrue(class_exists(\Std\HttpMessageManager\HttpMessageManager::class));
        // trait
        $this->assertTrue(trait_exists(\Std\HttpMessageManager\HttpMessageManagerAwareTrait::class));
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
        $HttpMessageManager = $ObjectManager->create(
            \Std\HttpMessageManager\HttpMessageManagerInterface::class,
            \Std\HttpMessageManager\HttpMessageManager::class
        );
        $this->assertInstanceOf(\Std\HttpMessageManager\HttpMessageManagerInterface::class, $HttpMessageManager);
    }
}
