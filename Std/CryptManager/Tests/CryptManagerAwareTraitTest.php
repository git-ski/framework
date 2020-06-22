<?php

namespace Test\Std\CryptManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\CryptManager\CryptManagerAwareTrait;
use Std\CryptManager\CryptManagerInterface;
use Std\CryptManager\CryptManager;

/**
 * Class CryptManagerAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\CryptManager\CryptManagerAwareTrait
 */
class CryptManagerAwareTraitTest extends TestCase
{
    /**
     * @var CryptManagerAwareTrait $cryptManagerAwareTrait An instance of "CryptManagerAwareTrait" to test.
     */
    private $cryptManagerAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->cryptManagerAwareTrait = $this->getMockBuilder(CryptManagerAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\CryptManager\CryptManagerAwareTrait::setCryptManager
     */
    public function testSetGetCryptManager(): void
    {
        $CryptManager = new CryptManager();
        $this->cryptManagerAwareTrait->setCryptManager($CryptManager);
        $this->assertTrue($CryptManager === $this->cryptManagerAwareTrait->getCryptManager());
    }
}
