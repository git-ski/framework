<?php

namespace Test\Std\AclManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\AclManager\AclManagerAwareTrait;
use Std\AclManager\AclManagerInterface;
use Std\AclManager\AclManager;

/**
 * Class AclManagerAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\AclManager\AclManagerAwareTrait
 */
class AclManagerAwareTraitTest extends TestCase
{
    /**
     * @var AclManagerAwareTrait $aclManagerAwareTrait An instance of "AclManagerAwareTrait" to test.
     */
    private $aclManagerAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->aclManagerAwareTrait = $this->getMockBuilder(AclManagerAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\AclManager\AclManagerAwareTrait::setAclManager
     * @covers \Std\AclManager\AclManagerAwareTrait::getAclManager
     */
    public function testSetGetAclManager(): void
    {
        $this->aclManagerAwareTrait->setAclManager(new AclManager());
        $this->assertTrue($this->aclManagerAwareTrait->getAclManager() instanceof AclManagerInterface);
    }
}
