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

namespace Std\HttpMessageManager\Tests;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Std\HttpMessageManager\HttpMessageManagerInterface;
use Laminas\Diactoros\Response\EmptyResponse;

/**
 * Class MailerServiceTest
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class HttpMessageManagerTest extends TestCase
{
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
     *
     */
    public function testServiceRequest()
    {
        $HttpMessageManager = ObjectManager::getSingleton()->get(HttpMessageManagerInterface::class);
        $this->assertInstanceOf(ServerRequestInterface::class, $HttpMessageManager->getRequest());
    }

    /**
     *
     */
    public function testContentSecurityPolicy()
    {
        $HttpMessageManager = ObjectManager::getSingleton()->get(HttpMessageManagerInterface::class);
        $this->assertNotEmpty($HttpMessageManager->getNonce());
    }

    /**
     *
     */
    public function testResponse()
    {
        $HttpMessageManager = ObjectManager::getSingleton()->get(HttpMessageManagerInterface::class);
        $this->assertInstanceOf(ResponseInterface::class, $HttpMessageManager->getResponse());
        // setResponse
        $RedirectResponse = new EmptyResponse();
        $HttpMessageManager->setResponse($RedirectResponse);
        $this->assertEquals($RedirectResponse, $HttpMessageManager->getResponse());
    }

    /**
     * Test send response
     *
     */
    public function testResponseException()
    {
        $this->expectException(\RuntimeException::class);
        $HttpMessageManager = ObjectManager::getSingleton()->get(HttpMessageManagerInterface::class);
        $RedirectResponse = new EmptyResponse();
        $HttpMessageManager->setResponse($RedirectResponse)->sendResponse();
     }

    /**
     *
     */
    public function testStream()
    {
        $HttpMessageManager = ObjectManager::getSingleton()->get(HttpMessageManagerInterface::class);
        $Stream = $HttpMessageManager->createStream('テスト');
        $this->assertInstanceOf(StreamInterface::class, $Stream);
        // Streamが重複に生成しない
        $Stream2 = $HttpMessageManager->createStream($Stream);
        $this->assertEquals($Stream, $Stream2);
    }

    /**
     *
     */
    public function testStreamFailture()
    {
        $this->expectException(\InvalidArgumentException::class);
        $HttpMessageManager = ObjectManager::getSingleton()->get(HttpMessageManagerInterface::class);
        $HttpMessageManager->createStream(1234);
    }
}
