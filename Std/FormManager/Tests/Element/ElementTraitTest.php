<?php

namespace Test\Std\FormManager\Element;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FormManager\Element\ElementTrait;
use Std\FormManager\Form;
use Laminas\InputFilter\InputFilterInterface;
use Std\FormManager\Error;

/**
 * Class ElementTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Element\ElementTrait
 */
class ElementTraitTest extends TestCase
{
    /**
     * @var ElementTrait $elementTrait An instance of "ElementTrait" to test.
     */
    private $elementTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->elementTrait = $this->getMockBuilder(ElementTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::setForm
     */
    public function testSetForm(): void
    {
        $expected = $this->createMock(Form::class);

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('form');
        $property->setAccessible(true);
        $this->elementTrait->setForm($expected);

        $this->assertSame($expected, $property->getValue($this->elementTrait));
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::getForm
     */
    public function testGetForm(): void
    {
        $expected = $this->createMock(Form::class);

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('form');
        $property->setAccessible(true);
        $property->setValue($this->elementTrait, $expected);

        $this->assertSame($expected, $this->elementTrait->getForm());
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::setName
     */
    public function testSetName(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('name');
        $property->setAccessible(true);
        $this->elementTrait->setName($expected);

        $this->assertSame($expected, $property->getValue($this->elementTrait));
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::getName
     */
    public function testGetName(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('name');
        $property->setAccessible(true);
        $property->setValue($this->elementTrait, $expected);

        $this->assertSame($expected, $this->elementTrait->getName());
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::setOptions
     */
    public function testSetOptions(): void
    {
        $expected = ["a", "strings", "array"];

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('options');
        $property->setAccessible(true);
        $this->elementTrait->setOptions($expected);

        $this->assertSame($expected, $property->getValue($this->elementTrait));
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::getOptions
     */
    public function testGetOptions(): void
    {
        $expected = ["a", "strings", "array"];

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('options');
        $property->setAccessible(true);
        $property->setValue($this->elementTrait, $expected);

        $this->assertSame($expected, $this->elementTrait->getOptions());
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::setType
     */
    public function testSetType(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('type');
        $property->setAccessible(true);
        $this->elementTrait->setType($expected);

        $this->assertSame($expected, $property->getValue($this->elementTrait));
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::getType
     */
    public function testGetType(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('type');
        $property->setAccessible(true);
        $property->setValue($this->elementTrait, $expected);

        $this->assertSame($expected, $this->elementTrait->getType());
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::setValue
     */
    public function testSetValue(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('value');
        $property->setAccessible(true);
        $this->elementTrait->setValue($expected);

        $this->assertSame($expected, $property->getValue($this->elementTrait));
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::getValue
     */
    public function testGetValue(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('value');
        $property->setAccessible(true);
        $property->setValue($this->elementTrait, $expected);

        $this->assertSame($expected, $this->elementTrait->getValue());
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::setFieldsetName
     */
    public function testSetFieldsetName(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('fieldsetName');
        $property->setAccessible(true);
        $this->elementTrait->setFieldsetName($expected);

        $this->assertSame($expected, $property->getValue($this->elementTrait));
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::getFieldsetName
     */
    public function testGetFieldsetName(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('fieldsetName');
        $property->setAccessible(true);
        $property->setValue($this->elementTrait, $expected);

        $this->assertSame($expected, $this->elementTrait->getFieldsetName());
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::setAttr
     * @covers \Std\FormManager\Element\ElementTrait::getAttr
     * @covers \Std\FormManager\Element\ElementTrait::with
     */
    public function testSetAttr(): void
    {
        $expected = 'expected';
        $this->assertEmpty(
            $this->elementTrait->getAttr('key')
        );
        $this->elementTrait->with([
            'key' => $expected
        ]);
        $this->assertSame(
            $expected,
            $this->elementTrait->getAttr('key')
        );
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::setInputFilter
     */
    public function testSetInputFilter(): void
    {
        $expected = $this->createMock(InputFilterInterface::class);

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('inputFilter');
        $property->setAccessible(true);
        $this->elementTrait->setInputFilter($expected);

        $this->assertSame($expected, $property->getValue($this->elementTrait));
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::getInputFilter
     */
    public function testGetInputFilter(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('inputFilter');
        $property->setAccessible(true);
        $property->setValue($this->elementTrait, $expected);

        $this->assertSame($expected, $this->elementTrait->getInputFilter());
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::setLabel
     */
    public function testSetLabel(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('label');
        $property->setAccessible(true);
        $this->elementTrait->setLabel($expected);

        $this->assertSame($expected, $property->getValue($this->elementTrait));
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::getLabel
     */
    public function testGetLabel(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->elementTrait))
            ->getProperty('label');
        $property->setAccessible(true);
        $property->setValue($this->elementTrait, $expected);

        $this->assertSame($expected, $this->elementTrait->getLabel());
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::setError
     * @covers \Std\FormManager\Element\ElementTrait::getError
     */
    public function testSetGetError(): void
    {
        $expected = 'test';
        $this->elementTrait->setError($expected);
        $this->assertEquals(
            $expected,
            (string) $this->elementTrait->getError()
        );
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::setError
     * @covers \Std\FormManager\Element\ElementTrait::getError
     */
    public function testSetGetError2(): void
    {
        $this->assertTrue(
            $this->elementTrait->getError() instanceof Error
        );
        $this->assertEmpty(
            (string) $this->elementTrait->getError()
        );
        $expected = new Error('test');
        $this->elementTrait->setError($expected);
        $this->assertEquals(
            $expected,
            (string) $this->elementTrait->getError()
        );
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::setErrorClass
     * @covers \Std\FormManager\Element\ElementTrait::getErrorClass
     */
    public function testSetErrorClass(): void
    {
        $expected = 'test';
        $this->elementTrait->setErrorClass($expected);
        $this->assertEquals(
            $expected,
            $this->elementTrait->getErrorClass()
        );
    }

    /**
     * @covers \Std\FormManager\Element\ElementTrait::setErrorClass
     * @covers \Std\FormManager\Element\ElementTrait::getErrorClass
     */
    public function testSetErrorClass2(): void
    {
        $this->assertEmpty(
            $this->elementTrait->getErrorClass()
        );
    }
}
