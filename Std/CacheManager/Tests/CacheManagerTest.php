<?php

namespace Test\Std\CacheManager;

use Framework\ObjectManager\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\CacheManager\CacheManager;
use Laminas\Cache\Storage\StorageInterface;

/**
 * Class CacheManagerTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\CacheManager\CacheManager
 */
class CacheManagerTest extends TestCase
{
    /**
     * @var CacheManager $cacheManager An instance of "CacheManager" to test.
     */
    private $cacheManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $ObjeceManager = ObjectManager::getSingleton();
        $this->cacheManager = $ObjeceManager->create(CacheManager::class);
    }

    /**
     * @dataProvider cacheOptionProvide
     * @covers \Std\CacheManager\CacheManager::setCache
     * @covers \Std\CacheManager\CacheManager::getCache
     */
    public function testSetGetCache(): void
    {
        $Cache = $this->cacheManager->getCache(__METHOD__);
        $this->assertTrue($Cache instanceof StorageInterface);
    }

    /**
     * @covers \Std\CacheManager\CacheManager::detach
     */
    public function testDetach(): void
    {
        $Cache = $this->cacheManager->getCache(__METHOD__);
        $this->assertSame($Cache, $this->cacheManager->getCache(__METHOD__));
        $this->cacheManager->detach(__METHOD__);
        $this->assertNotSame($Cache, $this->cacheManager->getCache(__METHOD__));
    }

    /**
     * @dataProvider cacheOptionProvide
     * @covers \Std\CacheManager\CacheManager::flushAll
     */
    public function testFlushAll($option): void
    {
        $cacheManager = new CacheManager();
        $Cache = $cacheManager->getCache(__METHOD__, $option);
        $Cache->setItem(__METHOD__, __FUNCTION__);
        $this->assertSame(__FUNCTION__, $Cache->getItem(__METHOD__));
        $cacheManager->flushAll();
        $this->assertNull($Cache->getItem(__METHOD__));
    }

    public function cacheOptionProvide()
    {
        return [
            [
                [
                    'adapter' => [
                        'name' => 'memory',
                        'options' => [
                            'namespace' => null,
                        ],
                    ]
                ]
            ]
        ];
    }
}
