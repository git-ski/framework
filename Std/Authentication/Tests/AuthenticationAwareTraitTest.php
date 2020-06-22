<?php

namespace Test\Std\Authentication;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\Authentication\AuthenticationAwareTrait;
use Std\Authentication\AbstractAuthentication;
use Laminas\Authentication\Storage\StorageInterface;
use Laminas\Authentication\Adapter\AdapterInterface;

/**
 * Class AuthenticationAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\Authentication\AuthenticationAwareTrait
 */
class AuthenticationAwareTraitTest extends TestCase
{
    /**
     * @var AuthenticationAwareTrait $authenticationAwareTrait An instance of "AuthenticationAwareTrait" to test.
     */
    private $authenticationAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->authenticationAwareTrait = $this->getMockBuilder(AuthenticationAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\Authentication\AuthenticationAwareTrait::setAuthentication
     * @covers \Std\Authentication\AuthenticationAwareTrait::getAuthentication
     */
    public function testGetAuthentication(): void
    {
        $Authentication = $this->getMockBuilder(AbstractAuthentication::class)
                                        ->setConstructorArgs([$this->createMock(StorageInterface::class), $this->createMock(AdapterInterface::class)])
                                        ->getMockForAbstractClass();
        $this->authenticationAwareTrait->setAuthentication($Authentication);
        $this->assertSame(
            $Authentication, $this->authenticationAwareTrait->getAuthentication()
        );
    }
}
