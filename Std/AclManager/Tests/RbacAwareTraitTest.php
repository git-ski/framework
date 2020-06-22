<?php

namespace Test\Std\AclManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\AclManager\RbacAwareTrait;
use Std\AclManager\RbacInterface;
use Std\AclManager\Rbac;

/**
 * Class RbacAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\AclManager\RbacAwareTrait
 */
class RbacAwareTraitTest extends TestCase
{
    /**
     * @var RbacAwareTrait $rbacAwareTrait An instance of "RbacAwareTrait" to test.
     */
    private $rbacAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->rbacAwareTrait = $this->getMockBuilder(RbacAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\AclManager\RbacAwareTrait::setRbac
     * @covers \Std\AclManager\RbacAwareTrait::getRbac
     */
    public function testSetGetRbac(): void
    {
        $this->rbacAwareTrait->setRbac(new Rbac());
        $this->assertTrue($this->rbacAwareTrait->getRbac() instanceof RbacInterface);
    }
}
