<?php

namespace Test\Std\FormManager\Element;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FormManager\Element\Checkbox;
use Std\FormManager\FormManager;

/**
 * Class CheckboxTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Element\Checkbox
 */
class CheckboxTest extends TestCase
{
    /**
     * @var Checkbox $checkbox An instance of "Checkbox" to test.
     */
    private $checkbox;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->checkbox = new Checkbox();
        $this->checkbox->setOptions([
            'value_options' => [
                1 => 'one',
            ]
        ]);
    }

    /**
     * @covers \Std\FormManager\Element\Checkbox::makeInput
     */
    public function testMakeInput(): void
    {
        $expectValue = 1;
        $expectAttr  = FormManager::attrFormat([
            'class' => 'test'
        ]);
        $result = $this->checkbox->makeInput($expectValue, $expectAttr);
        $node  = (array) simplexml_load_string($result)->input;
        $this->assertEquals(
            'checkbox',
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
     * @covers \Std\FormManager\Element\Checkbox::makeConfirm
     */
    public function testMakeConfirm(): void
    {
        $expectValue = 1;
        $expectAttr  = FormManager::attrFormat([
            'class' => 'test'
        ]);
        $result = $this->checkbox->makeConfirm($expectValue, $expectAttr);
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

    /**
     * @covers \Std\FormManager\Element\Checkbox::makeConfirm
     */
    public function testMakeConfirmInvalid(): void
    {
        $expectValue = 'invalid';
        $expectAttr  = FormManager::attrFormat([
            'class' => 'test'
        ]);
        $result = $this->checkbox->makeConfirm($expectValue, $expectAttr);
        $node  = (array) simplexml_load_string($result)->input;
        $this->assertEmpty($node);
    }
}
