<?php

namespace Test\Std\FormManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FormManager\ElementAwareTrait;
use Std\FormManager\Element\FormElementInterface;

/**
 * Class ElementAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\ElementAwareTrait
 */
class ElementAwareTraitTest extends TestCase
{
    /**
     * @var ElementAwareTrait $elementAwareTrait An instance of "ElementAwareTrait" to test.
     */
    private $elementAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->elementAwareTrait = $this->getMockBuilder(ElementAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\FormManager\ElementAwareTrait::setElements
     */
    public function testSetElements(): void
    {
        $expected = [
            $this->createMock(FormElementInterface::class),
            $this->createMock(FormElementInterface::class),
            $this->createMock(FormElementInterface::class),
        ];

        $property = (new \ReflectionClass($this->elementAwareTrait))
            ->getProperty('elements');
        $property->setAccessible(true);
        $this->elementAwareTrait->setElements($expected);

        $this->assertSame($expected, $property->getValue($this->elementAwareTrait));
    }

    /**
     * @covers \Std\FormManager\ElementAwareTrait::getElements
     */
    public function testGetElements(): void
    {
        $expected = [
            $this->createMock(FormElementInterface::class),
            $this->createMock(FormElementInterface::class),
            $this->createMock(FormElementInterface::class),
        ];

        $property = (new \ReflectionClass($this->elementAwareTrait))
            ->getProperty('elements');
        $property->setAccessible(true);
        $property->setValue($this->elementAwareTrait, $expected);

        $this->assertSame($expected, $this->elementAwareTrait->getElements());
    }

    /**
     * @covers \Std\FormManager\ElementAwareTrait::setElement
     * @covers \Std\FormManager\ElementAwareTrait::getElement
     * @covers \Std\FormManager\ElementAwareTrait::removeElement
     */
    public function testSetElement(): void
    {
        $expected = $this->createMock(FormElementInterface::class);
        $this->elementAwareTrait->setElement('test', $expected);
        $this->assertSame(
            $expected,
            $this->elementAwareTrait->getElement('test')
        );
        $this->elementAwareTrait->removeElement('test');
        $this->assertEmpty(
            $this->elementAwareTrait->getElement('test')
        );
    }

    public function testPopulateValuesException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->elementAwareTrait->populateValues(null);
    }

    /**
     * @covers \Std\FormManager\ElementAwareTrait::isValid
     */
    public function testIsValid(): void
    {
        $valid = $this->createMock(FormElementInterface::class);
        $valid->method('isValid')->willReturn(true);
        $this->elementAwareTrait->setElement('test', $valid);
        $this->assertTrue(
            $this->elementAwareTrait->isValid()
        );
        $invalid = $this->createMock(FormElementInterface::class);
        $invalid->method('isValid')->willReturn(false);
        $this->elementAwareTrait->setElement('test', $invalid);
        $this->assertFalse(
            $this->elementAwareTrait->isValid()
        );
    }
}
