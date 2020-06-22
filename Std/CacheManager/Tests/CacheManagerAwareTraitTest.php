<?php

namespace Test\Std\CacheManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\CacheManager\CacheManagerAwareTrait;
use Std\CacheManager\CacheManager;
use Std\CacheManager\CacheManagerInterface;

/**
 * Class CacheManagerAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\CacheManager\CacheManagerAwareTrait
 */
class CacheManagerAwareTraitTest extends TestCase
{
    /**
     * @var CacheManagerAwareTrait $cacheManagerAwareTrait An instance of "CacheManagerAwareTrait" to test.
     */
    private $cacheManagerAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->cacheManagerAwareTrait = $this->getMockBuilder(CacheManagerAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\CacheManager\CacheManagerAwareTrait::setCacheManager
     * @covers \Std\CacheManager\CacheManagerAwareTrait::getCacheManager
     */
    public function testSetGetCacheManager(): void
    {
        $this->cacheManagerAwareTrait->setCacheManager(new CacheManager());
        $this->assertTrue($this->cacheManagerAwareTrait->getCacheManager() instanceof CacheManagerInterface);
    }
}
