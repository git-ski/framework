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
namespace Std\MailerService\Tests;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\MailerService;

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
        $this->assertTrue(interface_exists(MailerService\MailerServiceInterface::class));
        $this->assertTrue(interface_exists(MailerService\MailerServiceAwareInterface::class));
        $this->assertTrue(interface_exists(MailerService\MessageInterface::class));
        $this->assertTrue(interface_exists(MailerService\AttachmentInterface::class));
        // class
        $this->assertTrue(class_exists(MailerService\Message::class));
        $this->assertTrue(class_exists(MailerService\Attachment::class));
        $this->assertTrue(class_exists(MailerService\MessageRender::class));
        // trait
        $this->assertTrue(trait_exists(MailerService\MailerServiceAwareTrait::class));
        $this->assertTrue(trait_exists(MailerService\MessageTrait::class));
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
        $MailerService = $ObjectManager->create(
            MailerService\MailerServiceInterface::class,
            MailerService\Zend\MailerService::class
        );
        $this->assertInstanceOf(MailerService\MailerServiceInterface::class, $MailerService);
        $Message = $ObjectManager->create(
            MailerService\MessageInterface::class,
            MailerService\Message::class
        );
        $this->assertInstanceOf(MailerService\MessageInterface::class, $Message);
        $Attachment = $ObjectManager->create(
            MailerService\AttachmentInterface::class,
            MailerService\Attachment::class
        );
        $this->assertInstanceOf(MailerService\AttachmentInterface::class, $Attachment);
    }
}
