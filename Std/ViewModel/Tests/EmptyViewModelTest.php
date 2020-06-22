<?php

namespace Test\Std\ViewModel;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\ViewModel\EmptyViewModel;

/**
 * Class EmptyViewModelTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\ViewModel\EmptyViewModel
 */
class EmptyViewModelTest extends TestCase
{
    /**
     * @var EmptyViewModel $emptyViewModel An instance of "EmptyViewModel" to test.
     */
    private $emptyViewModel;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->emptyViewModel = new EmptyViewModel();
    }

    /**
     * @covers \Std\ViewModel\EmptyViewModel::setTemplate
     */
    public function testSetGetTemplate(): void
    {
        $this->emptyViewModel->setTemplate(__FILE__);
        $this->assertEmpty(
            $this->emptyViewModel->getTemplate()
        );
    }

    /**
     * @covers \Std\ViewModel\EmptyViewModel::setTemplateDir
     */
    public function testSetGetTemplateDir(): void
    {
        $this->emptyViewModel->setTemplateDir(__DIR__);
        $this->assertEmpty(
            $this->emptyViewModel->getTemplateDir()
        );
    }

    /**
     * @covers \Std\ViewModel\EmptyViewModel::getId
     */
    public function testGetId(): void
    {
        $this->assertEmpty(
            $this->emptyViewModel->getId()
        );
    }

    /**
     * @covers \Std\ViewModel\EmptyViewModel::setData
     */
    public function testSetData(): void
    {
        $this->emptyViewModel->setData([
            __METHOD__ => __CLASS__
        ]);
        $this->assertEmpty(
            $this->emptyViewModel->getData()
        );
    }

    /**
     * @covers \Std\ViewModel\EmptyViewModel::render
     */
    public function testRender(): void
    {
        $this->assertEmpty(
            $this->emptyViewModel->render()
        );
    }

    /**
     * @covers \Std\ViewModel\EmptyViewModel::getTemplateForRender
     */
    public function testGetTemplateForRender(): void
    {
        $this->assertEmpty(
            $this->emptyViewModel->getTemplateForRender()
        );
    }

    /**
     * @covers \Std\ViewModel\EmptyViewModel::renderHtml
     */
    public function testRenderHtml(): void
    {
        $this->assertEmpty(
            $this->emptyViewModel->renderHtml()
        );
    }

    /**
     * @covers \Std\ViewModel\EmptyViewModel::getContainer
     */
    public function testGetContainer(): void
    {
        $this->assertEmpty(
            $this->emptyViewModel->getContainer(__CLASS__)
        );
    }

    /**
     * @covers \Std\ViewModel\EmptyViewModel::getLayout
     */
    public function testGetLayout(): void
    {
        $this->assertEmpty(
            $this->emptyViewModel->getLayout()
        );
    }

    /**
     * @covers \Std\ViewModel\EmptyViewModel::getSecureNonce
     */
    public function testGetSecureNonce(): void
    {
        $this->assertEmpty(
            $this->emptyViewModel->getSecureNonce()
        );
    }

    /**
     * @covers \Std\ViewModel\EmptyViewModel::init
     */
    public function testInit(): void
    {
        $this->assertEmpty(
            $this->emptyViewModel->init()
        );
    }
}
