<?php

namespace Test\Std\FormManager\Element;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FormManager\Element\Hidden;
use Std\FormManager\FormManager;

/**
 * Class HiddenTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Element\Hidden
 */
class HiddenTest extends TestCase
{
    /**
     * @var Hidden $hidden An instance of "Hidden" to test.
     */
    private $hidden;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->hidden = new Hidden();
    }

    /**
     * @covers \Std\FormManager\Element\Hidden::makeInput
     */
    public function testMakeInput(): void
    {
        $expectValue = 'value';
        $expectAttr  = FormManager::attrFormat([
            'class' => 'test'
        ]);
        $result = $this->hidden->makeInput($expectValue, $expectAttr);
        $node  = (array) simplexml_load_string($result);
        $this->assertEquals(
            'hidden',
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
     * @covers \Std\FormManager\Element\Hidden::makeConfirm
     */
    public function testMakeConfirm(): void
    {
        $expectValue = 'value';
        $expectAttr  = FormManager::attrFormat([
            'class' => 'test'
        ]);
        $result = $this->hidden->makeConfirm($expectValue, $expectAttr);
        $node  = (array) simplexml_load_string($result);
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
