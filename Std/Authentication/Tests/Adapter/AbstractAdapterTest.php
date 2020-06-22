<?php

namespace Test\Std\Authentication\Adapter;

use PHPUnit\Framework\MockObject\MockObject;
use Framework\ObjectManager\ObjectManager;
use PHPUnit\Framework\TestCase;
use Std\Authentication\Adapter\AbstractAdapter;
use Laminas\Crypt\Password\PasswordInterface;

/**
 * Class AbstractAdapterTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\Authentication\Adapter\AbstractAdapter
 */
class AbstractAdapterTest extends TestCase
{
    /**
     * @var AbstractAdapter $abstractAdapter An instance of "AbstractAdapter" to test.
     */
    private $abstractAdapter;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->abstractAdapter = $this->getMockBuilder(AbstractAdapter::class)
            ->setConstructorArgs(["a string to test", "a string to test"])
            ->getMockForAbstractClass();
        ObjectManager::getSingleton()->set(__CLASS__, $this->abstractAdapter);
    }

    /**
     * @covers \Std\Authentication\Adapter\AbstractAdapter::setUsername
     */
    public function testSetUsername(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->abstractAdapter))
            ->getProperty('username');
        $property->setAccessible(true);
        $this->abstractAdapter->setUsername($expected);

        $this->assertSame($expected, $property->getValue($this->abstractAdapter));
    }

    /**
     * @covers \Std\Authentication\Adapter\AbstractAdapter::getUsername
     */
    public function testGetUsername(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->abstractAdapter))
            ->getProperty('username');
        $property->setAccessible(true);
        $property->setValue($this->abstractAdapter, $expected);

        $this->assertSame($expected, $this->abstractAdapter->getUsername());
    }

    /**
     * @covers \Std\Authentication\Adapter\AbstractAdapter::setPassword
     */
    public function testSetPassword(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->abstractAdapter))
            ->getProperty('password');
        $property->setAccessible(true);
        $this->abstractAdapter->setPassword($expected);

        $this->assertSame($expected, $property->getValue($this->abstractAdapter));
    }

    /**
     * @covers \Std\Authentication\Adapter\AbstractAdapter::getPassword
     */
    public function testGetPassword(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->abstractAdapter))
            ->getProperty('password');
        $property->setAccessible(true);
        $property->setValue($this->abstractAdapter, $expected);

        $this->assertSame($expected, $this->abstractAdapter->getPassword());
    }

    /**
     * @covers \Std\Authentication\Adapter\AbstractAdapter::getCrypt
     */
    public function testGetCrypt(): void
    {
        $this->assertTrue(
            $this->abstractAdapter->getCrypt() instanceof PasswordInterface
        );
    }
}
