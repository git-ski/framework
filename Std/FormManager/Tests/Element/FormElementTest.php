<?php

namespace Test\Std\FormManager\Element;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FormManager\Element\FormElement;
use Std\FormManager\Element\FormElementInterface;
use Std\EntityManager\EntityInterface;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\Input;

/**
 * Class FormElementTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Element\FormElement
 */
class FormElementTest extends TestCase
{
    /**
     * @var FormElement $formElement An instance of "FormElement" to test.
     */
    private $formElement;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->formElement = $this->getMockBuilder(FormElement::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
    }

    /**
     * @covers \Std\FormManager\Element\FormElement::isRequired
     */
    public function testIsRequired(): void
    {
        $this->assertFalse(
            $this->formElement->isRequired()
        );
        $inputFilterMock = $this->createMock(InputFilter::class);
        $inputMock       = $this->createMock(Input::class);
        $inputFilterMock->method('get')->willReturn($inputMock);
        $inputMock->method('isRequired')->willReturn(true);
        $this->formElement->setInputFilter($inputFilterMock);
        $this->assertTrue(
            $this->formElement->isRequired()
        );
    }

    /**
     * @covers \Std\FormManager\Element\FormElement::toString
     */
    public function testToString(): void
    {
        $this->formElement->setValue(
            $this->createMock(EntityInterface::class)
        );
        $this->expectException(\LogicException::class);
        $this->formElement->toString();
    }
}
