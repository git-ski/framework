<?php

namespace Test\Std\FormManager\Element;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FormManager\Element\Button;
use Std\FormManager\FormManager;

/**
 * Class ButtonTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Element\Button
 */
class ButtonTest extends TestCase
{
    /**
     * @var Button $button An instance of "Button" to test.
     */
    private $button;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->button = new Button();
    }

    /**
     * @covers \Std\FormManager\Element\Button::makeInput
     */
    public function testMakeInput(): void
    {
        $expectValue = 'value';
        $expectAttr  = FormManager::attrFormat([
            'class' => 'test'
        ]);
        $result = $this->button->makeInput($expectValue, $expectAttr);
        $node  = (array) simplexml_load_string($result);
        $this->assertEquals(
            'button',
            $node['@attributes']['type']
        );
        $this->assertEquals(
            $expectValue,
            $node['@attributes']['value']
        );
        $this->assertEquals(
            'test',
            $node['@attributes']['class']
        );
    }

    /**
     * @covers \Std\FormManager\Element\Button::makeConfirm
     */
    public function testMakeConfirm(): void
    {
        $expectValue = 'value';
        $expectAttr  = FormManager::attrFormat([
            'class' => 'test'
        ]);
        $result = $this->button->makeConfirm($expectValue, $expectAttr);
        $node  = (array) simplexml_load_string($result)->input;
        $this->assertEquals(
            'hidden',
            $node['@attributes']['type']
        );
        $this->assertEquals(
            $expectValue,
            $node['@attributes']['value']
        );
    }
}
