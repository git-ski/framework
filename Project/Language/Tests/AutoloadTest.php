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
namespace Project\Language\Tests;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Project\Language\LanguageServiceInterface;
use Project\Language\LanguageServiceAwareInterface;
use Project\Language\LanguageServiceAwareTrait;
use Project\Language\LanguageService;

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
        $this->assertTrue(interface_exists(LanguageServiceInterface::class));
        $this->assertTrue(interface_exists(LanguageServiceAwareInterface::class));
        // class
        $this->assertTrue(class_exists(LanguageService::class));
        // trait
        $this->assertTrue(trait_exists(LanguageServiceAwareTrait::class));
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
        $LanguageService = $ObjectManager->create(
            LanguageServiceInterface::class,
            LanguageService::class
        );
        $this->assertInstanceOf(LanguageServiceInterface::class, $LanguageService);
    }
}
