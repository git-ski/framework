<?php

namespace Test\Std\EntityManager;

use Framework\ObjectManager\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\EntityManager\RepositoryManager;
use Std\EntityManager\EntityManagerInterface;

/**
 * Class RepositoryManagerTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\EntityManager\RepositoryManager
 */
class RepositoryManagerTest extends TestCase
{
    /**
     * @var RepositoryManager $repositoryManager An instance of "RepositoryManager" to test.
     */
    private $repositoryManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $ObjectManager = ObjectManager::getSingleton();
        $this->repositoryManager = $ObjectManager->get(RepositoryManager::class);
    }

    /**
     * @covers \Std\EntityManager\RepositoryManager::addEntityPath
     * @covers \Std\EntityManager\RepositoryManager::getEntityPath
     */
    public function testAddAndGetEntityPath(): void
    {
        $this->repositoryManager->addEntityPath(__DIR__);
        $this->assertContains(__DIR__, $this->repositoryManager->getEntityPath());
    }

    /**
     * @covers \Std\EntityManager\RepositoryManager::getEntityFiles
     * @covers \Std\EntityManager\RepositoryManager::getEntityClass
     */
    public function testGetEntityFilesClass(): void
    {
        $ObjectManager = ObjectManager::getSingleton();
        $EntityManager = $ObjectManager->get(EntityManagerInterface::class);
        $DoctrineMetadata = $EntityManager->getMetadataFactory()->getAllMetadata();
        $Files = $this->repositoryManager->getEntityFiles();
        $Classes = $this->repositoryManager->getEntityClass();
        foreach ($DoctrineMetadata as $Meta) {
            $this->assertContains($Meta->name, $Classes);
            $this->assertContains($Meta->reflClass->getFileName(), $Files);
        }
    }
}
