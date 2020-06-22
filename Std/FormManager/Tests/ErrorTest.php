<?php

namespace Test\Std\FormManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FormManager\Error;

/**
 * Class ErrorTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Error
 */
class ErrorTest extends TestCase
{
    /**
     * @var Error $error An instance of "Error" to test.
     */
    private $error;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->error = new Error();
    }

    /**
     * @covers \Std\FormManager\Error::setClass
     */
    public function testSetClass(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->error))
            ->getProperty('class');
        $property->setAccessible(true);
        $this->error->setClass($expected);

        $this->assertSame($expected, $property->getValue($this->error));
    }

    /**
     * @covers \Std\FormManager\Error::setMessage
     */
    public function testSetMessage(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->error))
            ->getProperty('message');
        $property->setAccessible(true);
        $this->error->setMessage($expected);

        $this->assertSame($expected, $property->getValue($this->error));
    }

    /**
     * @covers \Std\FormManager\Error::getMessage
     */
    public function testGetMessage(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->error))
            ->getProperty('message');
        $property->setAccessible(true);
        $property->setValue($this->error, $expected);

        $this->assertSame($expected, $this->error->getMessage());
    }

    /**
     * @covers \Std\FormManager\Error::getClass
     */
    public function testGetClass(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->error))
            ->getProperty('class');
        $property->setAccessible(true);
        $property->setValue($this->error, $expected);

        $this->assertSame($expected, $this->error->getClass());
    }

    /**
     * @covers \Std\FormManager\Error::__toString
     */
    public function testToString(): void
    {
        $this->error->setMessage('test');
        $this->assertSame(
            'test',
            (string) $this->error
        );
    }
}
