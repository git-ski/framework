<?php

namespace Test\Std\FormManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\FormManager\FormManager;
use Std\FormManager\Form;

/**
 * Class FormManagerTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\FormManager
 */
class FormManagerTest extends TestCase
{
    /**
     * @var FormManager $formManager An instance of "FormManager" to test.
     */
    private $formManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->formManager = ObjectManager::getSingleton()->create(FormManager::class);
    }

    /**
     * @covers \Std\FormManager\FormManager::escape
     */
    public function testEscape(): void
    {
        $strings = [
            'normal' => 'hello, world',
            'dirty' => '<script>alert(1)</script>'
        ];
        $stringsEscaped = FormManager::escape($strings);
        $this->assertEquals($stringsEscaped, [
            'normal' => 'hello, world',
            'dirty' => '&lt;script&gt;alert(1)&lt;/script&gt;'
        ]);
    }

    /**
     * @covers \Std\FormManager\FormManager::escapeAttr
     */
    public function testEscapeAttr(): void
    {
        $attrs = [
            'normal' => 'test',
            'dirty' => '<script>alert(1)</script>'
        ];
        $attsEscaped = FormManager::escapeAttr($attrs);
        $this->assertEquals($attsEscaped, [
            'normal' => 'test',
            'dirty' => '&lt;script&gt;alert(1)&lt;/script&gt;'
        ]);
    }

    /**
     * @covers \Std\FormManager\FormManager::escapeUrl
     */
    public function testEscapeUrl(): void
    {
        $attrs = [
            'normal' => 'test',
            'dirty' => 'javascript::alert(123);'
        ];
        $attsEscaped = FormManager::escapeUrl($attrs);
        $this->assertEquals($attsEscaped, [
            'normal' => 'test',
            'dirty' => 'javascript%3A%3Aalert%28123%29%3B'
        ]);
    }

    /**
     * @covers \Std\FormManager\FormManager::attrFormat
     */
    public function testAttrFormat(): void
    {
        $attrs = [
            'id' => 'test',
            'value' => '<script>alert(1)</script>'
        ];
        $attrString = FormManager::attrFormat($attrs);
        $this->assertEquals($attrString, "id='test' value='&lt;script&gt;alert(1)&lt;/script&gt;'");
    }

    /**
     * @covers \Std\FormManager\FormManager::create
     */
    public function testCreate(): void
    {
        $form = $this->formManager->create(__FUNCTION__);
        $this->assertTrue(
            $form instanceof Form
        );
        $this->assertSame(
            __FUNCTION__,
            $form->getId()
        );
    }

    /**
     * @covers \Std\FormManager\FormManager::find
     */
    public function testFind(): void
    {
        $this->expectException(\ErrorException::class);
        $this->formManager->find('notExists');
    }

    /**
     * @covers \Std\FormManager\FormManager::getEscaper
     */
    public function testGetEscaper(): void
    {
        $property = (new \ReflectionClass($this->formManager))
            ->getProperty('escaper');
        $property->setAccessible(true);
        $property->setValue($this->formManager, null);
        $this->assertIsCallable([FormManager::getEscaper(), 'escapeHtml']);
        $this->assertIsCallable([FormManager::getEscaper(), 'escapeHtmlAttr']);
    }
}
