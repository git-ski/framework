<?php

namespace Test\Std\FormManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FormManager\FieldsetAwareTrait;
use Std\FormManager\FieldsetInterface;

/**
 * Class FieldsetAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\FieldsetAwareTrait
 */
class FieldsetAwareTraitTest extends TestCase
{
    /**
     * @var FieldsetAwareTrait $fieldsetAwareTrait An instance of "FieldsetAwareTrait" to test.
     */
    private $fieldsetAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->fieldsetAwareTrait = $this->getMockBuilder(FieldsetAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\FormManager\FieldsetAwareTrait::setFieldsets
     */
    public function testSetFieldsets(): void
    {
        $expected = ["a", "strings", "array"];

        $property = (new \ReflectionClass($this->fieldsetAwareTrait))
            ->getProperty('fieldsets');
        $property->setAccessible(true);
        $this->fieldsetAwareTrait->setFieldsets($expected);

        $this->assertSame($expected, $property->getValue($this->fieldsetAwareTrait));
    }

    /**
     * @covers \Std\FormManager\FieldsetAwareTrait::getFieldsets
     */
    public function testGetFieldsets(): void
    {
        $expected = ["a", "strings", "array"];

        $property = (new \ReflectionClass($this->fieldsetAwareTrait))
            ->getProperty('fieldsets');
        $property->setAccessible(true);
        $property->setValue($this->fieldsetAwareTrait, $expected);

        $this->assertSame($expected, $this->fieldsetAwareTrait->getFieldsets());
    }
}
