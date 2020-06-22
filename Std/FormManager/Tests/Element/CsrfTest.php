<?php

namespace Test\Std\FormManager\Element;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FormManager\Element\Csrf;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\Csrf as CsrfValidatorAlias;

/**
 * Class CsrfTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Element\Csrf
 */
class CsrfTest extends TestCase
{
    /**
     * @var Csrf $csrf An instance of "Csrf" to test.
     */
    private $csrf;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->csrf = new Csrf();
    }

    /**
     * @covers \Std\FormManager\Element\Csrf::getValue
     */
    public function testGetValue(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->csrf))
            ->getProperty('value');
        $property->setAccessible(true);
        $property->setValue($this->csrf, $expected);

        $this->assertSame($expected, $this->csrf->getValue());
    }

    /**
     * @covers \Std\FormManager\Element\Csrf::setValue
     */
    public function testSetValue(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->csrf))
            ->getProperty('value');
        $property->setAccessible(true);
        $this->csrf->setValue($expected);

        $this->assertSame($expected, $property->getValue($this->csrf));
    }

    /**
     * @covers \Std\FormManager\Element\Csrf::getCsrfValidator
     */
    public function testGetCsrfValidator(): void
    {
        $expected = $this->createMock(CsrfValidatorAlias::class);

        $property = (new \ReflectionClass($this->csrf))
            ->getProperty('csrfValidator');
        $property->setAccessible(true);
        $property->setValue($this->csrf, $expected);

        $this->assertSame($expected, $this->csrf->getCsrfValidator());
    }

    /**
     * @covers \Std\FormManager\Element\Csrf::setCsrfValidator
     */
    public function testSetCsrfValidator(): void
    {
        $expected = $this->createMock(CsrfValidatorAlias::class);

        $property = (new \ReflectionClass($this->csrf))
            ->getProperty('csrfValidator');
        $property->setAccessible(true);
        $this->csrf->setCsrfValidator($expected);

        $this->assertSame($expected, $property->getValue($this->csrf));
    }
}
