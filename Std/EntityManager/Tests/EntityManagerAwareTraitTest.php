<?php

namespace Test\Std\EntityManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\EntityManager\EntityManagerAwareTrait;
use Std\EntityManager\EntityManagerInterface;

/**
 * Class EntityManagerAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\EntityManager\EntityManagerAwareTrait
 */
class EntityManagerAwareTraitTest extends TestCase
{
    /**
     * @var EntityManagerAwareTrait $entityManagerAwareTrait An instance of "EntityManagerAwareTrait" to test.
     */
    private $entityManagerAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->entityManagerAwareTrait = $this->getMockBuilder(EntityManagerAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\EntityManager\EntityManagerAwareTrait::setEntityManager
     * @covers \Std\EntityManager\EntityManagerAwareTrait::getEntityManager
     */
    public function testSetGetEntityManager(): void
    {
        $this->assertTrue($this->entityManagerAwareTrait->getEntityManager() instanceof EntityManagerInterface);
        $EntityManager = ObjectManager::getSingleton()->get(EntityManagerInterface::class);
        $this->entityManagerAwareTrait->setEntityManager($EntityManager);
        $this->assertSame($EntityManager, $this->entityManagerAwareTrait->getEntityManager());
    }
}
