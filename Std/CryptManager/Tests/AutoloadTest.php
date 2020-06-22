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
namespace Std\CryptManager\Tests;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\CryptManager\CryptManagerInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareTrait;
use Std\CryptManager\CryptManager;

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
        $this->assertTrue(interface_exists(CryptManagerInterface::class));
        $this->assertTrue(interface_exists(CryptManagerAwareInterface::class));
        // class
        $this->assertTrue(class_exists(CryptManager::class));
        // trait
        $this->assertTrue(trait_exists(CryptManagerAwareTrait::class));
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
        $CryptManager = $ObjectManager->create(
            CryptManagerInterface::class,
            CryptManager::class
        );
        $this->assertInstanceOf(CryptManagerInterface::class, $CryptManager);
    }
}
