<?php
/**
 * PHP version 7
 * File MailerServiceTest.php
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
 * Class MailerServiceTest
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class MailerServiceTest extends TestCase
{
    const TO = 'test@example.com';
    // const TO = 'gpgkd906@gmail.com';
    /**
    * setUpBeforeClass
    *
    * @api
    * @access
    * @return  null
    * @example
    * @since
    */
    public static function setUpBeforeClass() : void
    {
    }

    /**
    * tearDownAfterClass
    *
    * @api
    * @access
    * @return  null
    * @example
    * @since
    */
    public static function tearDownAfterClass() : void
    {
    }

    /**
     * Test testTextMail
     * テンプレートなしのMailerServiceの使い方をテスト
     *
     */
    public function testTextMail()
    {
        $MailerService = ObjectManager::getSingleton()->get(MailerService\MailerServiceInterface::class);
        $Message = ObjectManager::getSingleton()->create(MailerService\Message::class);
        $Message->setTo([
            self::TO => 'テスト'
        ]);
        $Message->setSubject('MailerService Unitテスト テキストメール');
        $Message->setBody([
            'text' => '日本語テスト',
        ]);
        $this->assertEquals([
            'text' => '日本語テスト',
        ], $Message->getBody());
        $MailerService->send($Message);
    }

    /**
     * Test testHtmlMail
     * テンプレートなしのMailerServiceの使い方をテスト
     *
     */
    public function testHtmlMail()
    {
        $MailerService = ObjectManager::getSingleton()->get(MailerService\MailerServiceInterface::class);
        $Message = ObjectManager::getSingleton()->create(MailerService\Message::class);
        $Message->setTo([
            self::TO => 'テスト'
        ]);
        $Message->setSubject('MailerService Unitテスト HTMLメール');
        $Message->setBody([
            'html' => '<strong>タグテスト</strong>'
        ]);
        $this->assertEquals([
            'html' => '<strong>タグテスト</strong>'
        ], $Message->getBody());
        $MailerService->send($Message);
    }

    /**
     * Test testSimpleMail
     * テンプレートなしのMailerServiceの使い方をテスト
     *
     */
    public function testSimpleMail()
    {
        $MailerService = ObjectManager::getSingleton()->get(MailerService\MailerServiceInterface::class);
        $Message = ObjectManager::getSingleton()->create(MailerService\Message::class);
        $Message->setTo([
            self::TO => 'テスト'
        ]);
        $Message->setSubject('MailerService Unitテスト');
        $Message->setBody([
            'text' => '日本語テスト',
            'html' => '<strong>タグテスト</strong>'
        ]);
        $this->assertEquals([
            'text' => '日本語テスト',
            'html' => '<strong>タグテスト</strong>'
        ], $Message->getBody());
        $MailerService->send($Message);
    }

    /**
     * Test testMultiPartMailTemplate
     * Messagerのテンプレート機能を使うMailerServiceのテスト
     *
     */
    public function testMultiPartMailTemplate()
    {
        $MailerService = ObjectManager::getSingleton()->get(MailerService\MailerServiceInterface::class);
        $Message = ObjectManager::getSingleton()->create(Stub\TemplateMessage::class);
        $this->assertTrue($Message instanceof MailerService\MessageInterface);
        $Message->setTo([
            self::TO => 'テスト'
        ]);
        $Message->setSubject('Messagerのテンプレート機能を使うMailerServiceのテスト');

        $MailerService->send($Message);
    }

    /**
     * Test testSimpleMailWithAttachment
     * 添付ファイル付きメールテスト
     */
    public function testSimpleMailWithAttachment()
    {
        $MailerService = ObjectManager::getSingleton()->get(MailerService\MailerServiceInterface::class);
        $Message = ObjectManager::getSingleton()->create(MailerService\Message::class);
        $Message->setTo([
            self::TO => 'テスト'
        ]);
        $Message->setSubject('添付ファイル付きメールテスト');
        $Message->setBody([
            'text' => '添付ファイル付きメールテスト',
        ]);
        $this->assertEquals([
            'text' => '添付ファイル付きメールテスト',
        ], $Message->getBody());
        $Attachment = ObjectManager::getSingleton()->create(MailerService\Attachment::class);
        $Attachment->setPath(__DIR__ . '/Stub/Attachment/test.txt');
        $Attachment->setFileName('test_attachment.txt');
        $Message->addAttachments($Attachment);
        $MailerService->send($Message);
    }

    /**
     * Test testMultiPartMailWithAttachment
     * 添付ファイル付きマルチパーツメールテスト
     * @return void
     */
    public function testMultiPartMailWithAttachment()
    {
        $MailerService = ObjectManager::getSingleton()->get(MailerService\MailerServiceInterface::class);
        $Message = ObjectManager::getSingleton()->create(Stub\TemplateMessage::class);
        $this->assertTrue($Message instanceof MailerService\MessageInterface);
        $Message->setTo([
            self::TO => 'テスト'
        ]);
        $Message->setSubject('添付ファイル付きマルチパーツメールテスト');
        $Attachment = ObjectManager::getSingleton()->create(MailerService\Attachment::class);
        $Attachment->setPath(__DIR__ . '/Stub/Attachment/test.txt');
        $Attachment->setFileName('test_attachment.txt');
        $Message->addAttachments($Attachment);
        $MailerService->send($Message);
    }
}
