<?php

namespace Test\Std\Restful;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\Restful\AbstractRestfulController;
use Framework\ObjectManager\ObjectManager;
use Std\ViewModel\ViewModelInterface;
use Psr\Http\Message\ResponseInterface;
use Std\Restful\Tests\Stub\Restful;
use Psr\Http\Message\ServerRequestInterface;
use Std\HttpMessageManager\HttpMessageManagerInterface;
/**
 * Class AbstractRestfulControllerTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\Restful\AbstractRestfulController
 */
class AbstractRestfulControllerTest extends TestCase
{
    /**
     * @var AbstractRestfulController $abstractRestfulController An instance of "AbstractRestfulController" to test.
     */
    private $restfulController;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->restfulController = ObjectManager::getSingleton()->get(Restful::class);
        $property = (new \ReflectionClass(AbstractRestfulController::class))
            ->getProperty('response');
        $property->setAccessible(true);
        $property->setValue($this->restfulController, $this->createMock(ResponseInterface::class));
    }

    /**
     * @covers \Std\Restful\AbstractRestfulController::callActionFlow
     */
    public function testCallActionFlow(): void
    {
        $this->assertTrue(
            $this->restfulController->callActionFlow('create', []) instanceof ViewModelInterface
        );
    }

    /**
     * @covers \Std\Restful\AbstractRestfulController::callActionFlow
     */
    public function testCallActionFlow2(): void
    {
        $excepted = $this->createMock(ViewModelInterface::class);
        $this->restfulController->setViewModel($excepted);
        $this->assertSame(
            $excepted,
            $this->restfulController->callActionFlow('create', [0])
        );
    }

    /**
     * @covers \Std\Restful\AbstractRestfulController::callAction
     */
    public function testCallAction(): void
    {
        $this->assertTrue(
            $this->restfulController->callAction('getList', null) instanceof ViewModelInterface
        );
    }

    /**
     * @covers \Std\Restful\AbstractRestfulController::setViewModel
     */
    public function testSetViewModel(): void
    {
        $property = (new \ReflectionClass(AbstractRestfulController::class))
            ->getProperty('ViewModel');
        $property->setAccessible(true);
        $excepted = $this->createMock(ViewModelInterface::class);
        $this->restfulController->setViewModel($excepted);
        $this->assertSame($excepted, $property->getValue($this->restfulController));
    }

    /**
     * @covers \Std\Restful\AbstractRestfulController::parseRequest
     */
    public function testParseRequest(): void
    {
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $requestMock->method('getMethod')->willReturn('index');
        $this->restfulController->addHttpMethodHandler('index', [$this->restfulController, 'index']);
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $this->assertEquals([
            'success' => true,
            'data' => 'customerMethod',
        ], $this->restfulController->parseRequest());
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('delete');
        $result = $this->restfulController->parseRequest();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('get');
        $result = $this->restfulController->parseRequest();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('post');
        $result = $this->restfulController->parseRequest();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('put');
        $result = $this->restfulController->parseRequest();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('head');
        $result = $this->restfulController->parseRequest();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('options');
        $result = $this->restfulController->parseRequest();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
        //
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('invalidMethod');
        $result = $this->restfulController->parseRequest();
        $this->assertEmpty($result);
    }

    /**
     * @covers \Std\Restful\AbstractRestfulController::parseRequest
     */
    public function testParseRequest2(): void
    {
        $this->restfulController->setIdentifier(0);
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $requestMock->method('getMethod')->willReturn('index');
        $this->restfulController->addHttpMethodHandler('index', [$this->restfulController, 'index']);
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $this->assertEquals([
            'success' => true,
            'data' => 'customerMethod',
        ], $this->restfulController->parseRequest());
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('delete');
        $result = $this->restfulController->parseRequest();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('get');
        $result = $this->restfulController->parseRequest();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('post');
        $result = $this->restfulController->parseRequest();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('put');
        $result = $this->restfulController->parseRequest();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('head');
        $result = $this->restfulController->parseRequest();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('patch');
        $result = $this->restfulController->parseRequest();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
        //
        [$httpMessageMock, $requestMock] = $this->createMockHttpMessage();
        $this->restfulController->setHttpMessageManager($httpMessageMock);
        $requestMock->method('getMethod')->willReturn('options');
        $result = $this->restfulController->parseRequest();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\AbstractRestfulController::options
     */
    public function testOptions(): void
    {
        $result = $this->restfulController->options();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    public function createMockHttpMessage()
    {
        $httpMessageManagerMock = $this->createMock(HttpMessageManagerInterface::class);
        $requestMock = $this->createMock(ServerRequestInterface::class);
        $httpMessageManagerMock->method('getRequest')->willReturn($requestMock);
        $httpMessageManagerMock->method('getResponse')->willReturn($this->createMock(ResponseInterface::class));
        return [$httpMessageManagerMock, $requestMock];
    }
}
