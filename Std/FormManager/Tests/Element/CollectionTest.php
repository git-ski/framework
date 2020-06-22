<?php

namespace Test\Std\FormManager\Element;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\FormManager\Element\Collection;
use Std\FormManager\Element\FormElementInterface;
use Std\FormManager\FieldsetInterface;

/**
 * Class CollectionTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Element\Collection
 */
class CollectionTest extends TestCase
{
    /**
     * @var Collection $collection An instance of "Collection" to test.
     */
    private $collection;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->collection = ObjectManager::getSingleton()->create(Collection::class);
    }

    /**
     * @covers \Std\FormManager\Element\Collection::iterate
     */
    public function testIterate(): void
    {
        $expectedFieldset = [
            $this->createMock(FieldsetInterface::class),
            $this->createMock(FieldsetInterface::class),
            $this->createMock(FieldsetInterface::class),
            $this->createMock(FieldsetInterface::class),
        ];
        $this->collection->setFieldsets($expectedFieldset);
        $this->assertEquals(
            $expectedFieldset,
            \iterator_to_array($this->collection->iterate())
        );
    }

    /**
     * @covers \Std\FormManager\Element\Collection::makeInput
     */
    public function testMakeInput(): void
    {
        $this->expectException(\LogicException::class);
        $this->collection->makeInput('test', 'test');
    }

    /**
     * @covers \Std\FormManager\Element\Collection::makeConfirm
     */
    public function testMakeConfirm(): void
    {
        $this->expectException(\LogicException::class);
        $this->collection->makeConfirm('test', 'test');
    }

    /**
     * @covers \Std\FormManager\Element\Collection::__toString
     */
    public function testToString(): void
    {
        $this->collection->setFieldsetName('test');
        $property = (new \ReflectionClass($this->collection))
            ->getProperty('name');
        $property->setAccessible(true);
        $property->setValue($this->collection, 'collection');
        $this->assertSame(
            'test[collection]',
            (string) $this->collection
        );
    }

    /**
     * @covers \Std\FormManager\Element\Collection::__clone
     */
    public function testClone(): void
    {
        $expectedTarget = $this->createMock(FieldsetInterface::class);
        $expectedFieldset = $this->createMock(FieldsetInterface::class);
        $this->collection->setTargetElement($expectedTarget);
        $this->collection->setFieldsets([$expectedFieldset]);

        $clone = clone $this->collection;

        $this->assertEquals(
            $clone->getTargetElement(),
            $this->collection->getTargetElement(),
        );
        $this->assertNotSame(
            $clone->getTargetElement(),
            $this->collection->getTargetElement(),
        );
        $this->assertEquals(
            $clone->getFieldsets(),
            $this->collection->getFieldsets(),
        );
        $this->assertNotSame(
            $clone->getFieldsets(),
            $this->collection->getFieldsets(),
        );
    }

    /**
     * @covers \Std\FormManager\Element\Collection::getId
     */
    public function testGetId(): void
    {
        $this->collection->setTargetElement($this->createMock(FieldsetInterface::class));

        $this->assertNotEmpty(
            $this->collection->getId()
        );
        $clone = clone $this->collection;
        $this->assertNotSame(
            $clone->getId(),
            $this->collection->getId()
        );
    }
}
