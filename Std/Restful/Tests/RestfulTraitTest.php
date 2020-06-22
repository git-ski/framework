<?php

namespace Test\Std\Restful;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\Restful\RestfulTrait;
use Std\Restful\AbstractRestfulController;
use Std\Restful\Tests\Stub\Restful;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RestfulTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\Restful\RestfulTrait
 */
class RestfulTraitTest extends TestCase
{
    /**
     * @var RestfulTrait $restfulTrait An instance of "RestfulTrait" to test.
     */
    private $restfulTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->restfulTrait = ObjectManager::getSingleton()->get(Restful::class);
        $property = (new \ReflectionClass(AbstractRestfulController::class))
            ->getProperty('response');
        $property->setAccessible(true);
        $property->setValue($this->restfulTrait, $this->createMock(ResponseInterface::class));
    }

    /**
     * @covers \Std\Restful\RestfulTrait::setIdentifierName
     * @covers \Std\Restful\RestfulTrait::getIdentifierName
     */
    public function testSetIdentifierName(): void
    {
        $expected = 'identifiername';
        $this->restfulTrait->setIdentifierName($expected);
        $this->assertSame($expected, $this->restfulTrait->getIdentifierName());
    }

    /**
     * @covers \Std\Restful\RestfulTrait::create
     */
    public function testCreate(): void
    {
        $result = $this->restfulTrait->create([]);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::delete
     */
    public function testDelete(): void
    {
        $result = $this->restfulTrait->delete(0);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::deleteList
     */
    public function testDeleteList(): void
    {
        $result = $this->restfulTrait->deleteList([]);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::get
     */
    public function testGet(): void
    {
        $result = $this->restfulTrait->get(0);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::getList
     */
    public function testGetList(): void
    {
        $result = $this->restfulTrait->getList([]);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::head
     */
    public function testHead(): void
    {
        $result = $this->restfulTrait->head();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::patch
     */
    public function testPatch(): void
    {
        $result = $this->restfulTrait->patch(0, []);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::replaceList
     */
    public function testReplaceList(): void
    {
        $result = $this->restfulTrait->replaceList([]);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::patchList
     */
    public function testPatchList(): void
    {
        $result = $this->restfulTrait->patchList([]);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::update
     */
    public function testUpdate(): void
    {
        $result = $this->restfulTrait->update(0, []);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::notFound
     */
    public function testNotFound(): void
    {
        $result = $this->restfulTrait->notFound();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::unauthorized
     */
    public function testUnauthorized(): void
    {
        $result = $this->restfulTrait->unauthorized();
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::processPostData
     */
    public function testProcessPostData(): void
    {
        $expected = ['test' => __METHOD__];
        $requestMock = $this->createMock(ServerRequestInterface::class);
        $result = $this->restfulTrait->processPostData($requestMock);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('data', $result);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::getPostData
     */
    public function testGetPostData(): void
    {
        // query request
        $expected = ['test' => __METHOD__];
        $requestMock = $this->createMock(ServerRequestInterface::class);
        $requestMock->method('getParsedBody')->willReturn($expected);
        $this->assertEquals($expected, $this->restfulTrait->getPostData($requestMock));
        // json request
        $expected = ['test' => __METHOD__];
        $requestMock = $this->createMock(ServerRequestInterface::class);
        $requestMock->method('getBody')->willReturn(json_encode($expected));
        $requestMock->method('getHeader')->willReturn([
            'application/json'
        ]);
        $this->assertEquals($expected, $this->restfulTrait->getPostData($requestMock));
    }

    /**
     * @covers \Std\Restful\RestfulTrait::requestHasContentType
     */
    public function testRequestHasContentType(): void
    {
        $requestMock = $this->createMock(ServerRequestInterface::class);
        $this->assertFalse(
            $this->restfulTrait->requestHasContentType($requestMock, 'json')
        );
        $requestMock = $this->createMock(ServerRequestInterface::class);
        $requestMock->method('getHeader')->willReturn([
            'text/html'
        ]);
        $this->assertFalse(
            $this->restfulTrait->requestHasContentType($requestMock, 'json')
        );
        $requestMock = $this->createMock(ServerRequestInterface::class);
        $requestMock->method('getHeader')->willReturn([
            'application/json'
        ]);
        $this->assertTrue(
            $this->restfulTrait->requestHasContentType($requestMock, 'json')
        );
    }

    /**
     * @covers \Std\Restful\RestfulTrait::addHttpMethodHandler
     */
    public function testAddHttpMethodHandler(): void
    {
        $property = (new \ReflectionClass(AbstractRestfulController::class))
            ->getProperty('customHttpMethodsMap');
        $property->setAccessible(true);
        $expected = function () {};
        $this->restfulTrait->addHttpMethodHandler('test', $expected);
        $this->assertSame($expected, $property->getValue($this->restfulTrait)['test']);
    }

    /**
     * @covers \Std\Restful\RestfulTrait::addHttpMethodHandler
     */
    public function testAddHttpMethodHandlerException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->restfulTrait->addHttpMethodHandler('test', 'invalidCallable');
    }

    /**
     * @runInSeparateProcess
     * @covers \Std\Restful\RestfulTrait::setIdentifier
     * @covers \Std\Restful\RestfulTrait::getIdentifier
     */
    public function testSetGetIdentifier(): void
    {
        $requestMock = $this->createMock(ServerRequestInterface::class);
        $expected = 1;
        $requestMock->method('getQueryParams')->willReturn([
            'identifiername' => $expected
        ]);
        $this->restfulTrait->setIdentifierName('identifiername');
        $this->assertSame($expected, $this->restfulTrait->getIdentifier($requestMock));
        $this->restfulTrait->setIdentifier(2);
        $this->assertSame(2, $this->restfulTrait->getIdentifier($requestMock));
    }
}
