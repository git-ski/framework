<?php

namespace Test\Std\FormManager\Element;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FormManager\Element\CollectionTrait;
use Std\FormManager\Element\Collection;

/**
 * Class CollectionTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Element\CollectionTrait
 */
class CollectionTraitTest extends TestCase
{
    /**
     * @var CollectionTrait $collectionTrait An instance of "CollectionTrait" to test.
     */
    private $collectionTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->collectionTrait = $this->getMockBuilder(CollectionTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\FormManager\Element\CollectionTrait::populateValues
     */
    public function testPopulateValuesException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->collectionTrait->populateValues(123);
    }

    /**
     * @covers \Std\FormManager\Element\CollectionTrait::setCount
     */
    public function testSetCount(): void
    {
        $expected = 1;

        $property = (new \ReflectionClass($this->collectionTrait))
            ->getProperty('count');
        $property->setAccessible(true);
        $this->collectionTrait->setCount($expected);

        $this->assertSame($expected, $property->getValue($this->collectionTrait));
    }

    /**
     * @covers \Std\FormManager\Element\CollectionTrait::getCount
     */
    public function testGetCount(): void
    {
        $expected = 1;

        $property = (new \ReflectionClass($this->collectionTrait))
            ->getProperty('count');
        $property->setAccessible(true);
        $property->setValue($this->collectionTrait, $expected);

        $this->assertSame($expected, $this->collectionTrait->getCount());
    }

    /**
     * @covers \Std\FormManager\Element\CollectionTrait::setAllowAdd
     */
    public function testSetAllowAdd(): void
    {
        $expected = true;

        $property = (new \ReflectionClass($this->collectionTrait))
            ->getProperty('allowAdd');
        $property->setAccessible(true);
        $this->collectionTrait->setAllowAdd($expected);

        $this->assertSame($expected, $property->getValue($this->collectionTrait));
    }

    /**
     * @covers \Std\FormManager\Element\CollectionTrait::setAllowRemove
     */
    public function testSetAllowRemove(): void
    {
        $expected = false;

        $property = (new \ReflectionClass($this->collectionTrait))
            ->getProperty('allowRemove');
        $property->setAccessible(true);
        $this->collectionTrait->setAllowRemove($expected);

        $this->assertSame($expected, $property->getValue($this->collectionTrait));
    }

    /**
     * @covers \Std\FormManager\Element\CollectionTrait::setTemplatePlaceholder
     */
    public function testSetTemplatePlaceholder(): void
    {
        $expected = "__index__";

        $property = (new \ReflectionClass($this->collectionTrait))
            ->getProperty('templatePlaceholder');
        $property->setAccessible(true);
        $this->collectionTrait->setTemplatePlaceholder($expected);

        $this->assertSame($expected, $property->getValue($this->collectionTrait));
    }

    /**
     * @covers \Std\FormManager\Element\CollectionTrait::getTemplatePlaceholder
     */
    public function testGetTemplatePlaceholder(): void
    {
        $expected = "__index__";

        $property = (new \ReflectionClass($this->collectionTrait))
            ->getProperty('templatePlaceholder');
        $property->setAccessible(true);
        $property->setValue($this->collectionTrait, $expected);

        $this->assertSame($expected, $this->collectionTrait->getTemplatePlaceholder());
    }

    /**
     * @covers \Std\FormManager\Element\CollectionTrait::getTemplate
     */
    public function testGetTemplate(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->collectionTrait))
            ->getProperty('template');
        $property->setAccessible(true);
        $property->setValue($this->collectionTrait, $expected);

        $this->assertSame($expected, $this->collectionTrait->getTemplate());
    }
}
