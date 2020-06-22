<?php

namespace Test\Std\CryptManager\Password;

use Framework\ObjectManager\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\CryptManager\Password\BcryptSha1;

/**
 * Class BcryptSha1Test.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\CryptManager\Password\BcryptSha1
 */
class BcryptSha1Test extends TestCase
{
    /**
     * @var BcryptSha1 $bcryptSha1 An instance of "BcryptSha1" to test.
     */
    private $bcryptSha1;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $ObjeceManager = ObjectManager::getSingleton();
        $this->bcryptSha1 = $ObjeceManager->create(BcryptSha1::class);
    }

    /**
     * @covers \Std\CryptManager\Password\BcryptSha1::create
     */
    public function testCreateVerify(): void
    {
        $hash = $this->bcryptSha1->create(__METHOD__);
        $this->assertTrue($this->bcryptSha1->verify(__METHOD__, $hash));
    }
}
