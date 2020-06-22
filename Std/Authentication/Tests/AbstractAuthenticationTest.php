<?php

namespace Test\Std\Authentication;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\Authentication\AbstractAuthentication;
use Laminas\Authentication\Storage\StorageInterface;
use Laminas\Authentication\Adapter\AdapterInterface;
use Std\Authentication\Adapter\AbstractAdapter;
use Framework\ObjectManager\ObjectManager;
use Std\SessionManager\SessionManager;
use Laminas\Authentication\Storage\NonPersistent;

/**
 * Class AbstractAuthenticationTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\Authentication\AbstractAuthentication
 */
class AbstractAuthenticationTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
    }

    /**
     * @covers \Std\Authentication\AbstractAuthentication::login
     */
    public function testLogin(): void
    {
        // 成功パターン
        $Adapter = $this->createMock(AbstractAdapter::class);
        $Adapter->method('authenticate')->willReturn(true);
        $Storage = new NonPersistent();
        ObjectManager::getSingleton()->set(SessionManager::class, $this->createMock(SessionManager::class));

        $Authentication = (new class($Storage, $Adapter) extends AbstractAuthentication
        {
            public function login($username, $password)
            {
                return $this->getAdapter()->authenticate();
            }
        });
        $this->assertTrue($Authentication->login('test', 'test'));
        // 失敗パターン
        $Adapter = $this->createMock(AbstractAdapter::class);
        $Adapter->method('authenticate')->willReturn(false);
        $Storage = new NonPersistent();
        ObjectManager::getSingleton()->set(SessionManager::class, $this->createMock(SessionManager::class));

        $Authentication = (new class($Storage, $Adapter) extends AbstractAuthentication
        {
            public function login($username, $password)
            {
                return $this->getAdapter()->authenticate();
            }
        });
        $this->assertFalse($Authentication->login('test', 'test'));
    }

    /**
     * @covers \Std\Authentication\AbstractAuthentication::updateIdentity
     */
    public function testUpdateIdentity(): void
    {
        $Storage = new NonPersistent();
        $Storage->write([
            'init' => __METHOD__
        ]);
        ObjectManager::getSingleton()->set(SessionManager::class, $this->createMock(SessionManager::class));

        $Authentication = (new class($Storage) extends AbstractAuthentication
        {
            public function login($username, $password)
            {
                return true;
            }
        });
        $this->assertEquals([
            'init' => __METHOD__
        ], $Authentication->getIdentity());
        $Authentication->updateIdentity([
            'add' => __METHOD__
        ]);
        $this->assertEquals([
            'init' => __METHOD__,
            'add' => __METHOD__
        ], $Authentication->getIdentity());
    }
}
