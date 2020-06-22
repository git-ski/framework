<?php

namespace Test\Std\CryptManager\Password;

use Framework\ObjectManager\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\CryptManager\Password\Sha2Sha1;

/**
 * Class Sha2Sha1Test.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\CryptManager\Password\Sha2Sha1
 */
class Sha2Sha1Test extends TestCase
{
    /**
     * @var Sha2Sha1 $sha2Sha1 An instance of "Sha2Sha1" to test.
     */
    private $sha2Sha1;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $ObjeceManager = ObjectManager::getSingleton();
        $this->sha2Sha1 = $ObjeceManager->create(Sha2Sha1::class);
    }

    /**
     * @covers \Std\CryptManager\Password\Sha2Sha1::create
     * @covers \Std\CryptManager\Password\Sha2Sha1::verify
     */
    public function testCreateVerify(): void
    {
        $hash = $this->sha2Sha1->create(__METHOD__);
        $this->assertTrue($this->sha2Sha1->verify(__METHOD__, $hash));
    }

    /**
     * @covers \Std\CryptManager\Password\Sha2Sha1::passwordHash
     * @covers \Std\CryptManager\Password\Sha2Sha1::passwordVerify
     */
    public function testPasswordHash(): void
    {
        $PasswordHash = $this->sha2Sha1->passwordHash(__METHOD__);
        $this->assertTrue($this->sha2Sha1->passwordVerify(__METHOD__, $PasswordHash));
    }
}
