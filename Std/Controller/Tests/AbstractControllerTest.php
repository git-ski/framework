<?php

namespace Test\Std\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\Controller\Tests\Stub\Controller;
use Framework\ObjectManager\ObjectManager;
use Std\Controller\AbstractController;
use Std\ViewModel\ViewModelInterface;
use Laminas\I18n\Translator\TranslatorInterface;

/**
 * Class AbstractControllerTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\Controller\AbstractController
 */
class AbstractControllerTest extends TestCase
{
    /**
     * @var AbstractController $abstractController An instance of "AbstractController" to test.
     */
    private $controller;
    private $viewModel;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->viewModel = $this->createMock(ViewModelInterface::class);
        ObjectManager::getSingleton()->set(ViewModelInterface::class, $this->viewModel);
        $this->controller = ObjectManager::getSingleton()->create(Controller::class);
    }

    /**
     * @covers \Std\Controller\AbstractController::hasViewModel
     * @covers \Std\Controller\AbstractController::callActionFlow
     */
    public function testCallActionFlow(): void
    {
        $this->assertFalse($this->controller->hasViewModel());
        $ViewModel = $this->controller->callActionFlow('index');
        $this->assertSame($ViewModel, $this->viewModel);
        $this->assertTrue($this->controller->hasViewModel());
    }

    /**
     * @covers \Std\Controller\AbstractController::setViewModel
     */
    public function testSetViewModel(): void
    {
        $viewModelMock = $this->createMock(ViewModelInterface::class);
        $this->controller->setViewModel($viewModelMock);
        $ViewModel = $this->controller->callActionFlow('index', null);
        $this->assertSame($ViewModel, $viewModelMock);
        $this->assertNotSame($this->viewModel, $viewModelMock);
    }

    /**
     * @covers \Std\Controller\AbstractController::getViewModel
     */
    public function testGetViewModel(): void
    {
        $viewModelMock = $this->createMock(ViewModelInterface::class);
        $this->controller->setViewModel($viewModelMock);
        $this->assertSame($viewModelMock, $this->controller->getViewModel());
    }

    /**
     * @covers \Std\Controller\AbstractController::getPageInfo
     */
    public function testGetPageInfo(): void
    {
        $this->assertArrayHasKey('description', $this->controller::getPageInfo());
        $this->assertContains('description', $this->controller::getPageInfo());
    }

    /**
     * @covers \Std\Controller\AbstractController::getDescription
     */
    public function testGetDescription(): void
    {
        $this->assertEquals('description', $this->controller->getDescription());
    }

    /**
     * @covers \Std\Controller\AbstractController::getTranslator
     */
    public function testGetTranslator(): void
    {
        $this->assertTrue(
            $this->controller->getTranslator() instanceof TranslatorInterface
        );
    }
}
