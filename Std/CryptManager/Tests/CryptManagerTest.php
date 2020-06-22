<?php
/**
 * PHP version 7
 * File MailerServiceTest.php
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Test\Std\CryptManager;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Laminas\Crypt\Password\PasswordInterface;
use Laminas\Crypt\BlockCipher;
use Laminas\Crypt\FileCipher;
use Std\CryptManager\Secure\RandomString;
use Std\CryptManager\RandomStringInterface;
use Std\CryptManager\Tests\Stub\Mocker;

/**
 * Class MailerServiceTest
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class CryptManagerTest extends TestCase
{
    /**
    * setUpBeforeClass
    *
    * @api
    * @access
    * @return  null
    * @example
    * @since
    */
    public static function setUpBeforeClass() : void
    {
    }

    /**
    * tearDownAfterClass
    *
    * @api
    * @access
    * @return  null
    * @example
    * @since
    */
    public static function tearDownAfterClass() : void
    {
    }

    /**
     * パスワードインスタンス
     */
    public function testPassword()
    {
        $Mocker     = ObjectManager::getSingleton()->get(Mocker::class);
        $Password   = $Mocker->getCryptManager()->getPasswordCrypt();
        $this->assertInstanceOf(PasswordInterface::class, $Password);
    }

    /**
     * ブロック暗号化
     */
    public function testBlockCipher()
    {
        $Mocker        = ObjectManager::getSingleton()->get(Mocker::class);
        $BlockCipher   = $Mocker->getCryptManager()->getBlockCipher();
        $this->assertInstanceOf(BlockCipher::class, $BlockCipher);
        // 新しいブロック暗号機構もセットできる
        $newBlockCipher = BlockCipher::factory('openssl', ['algo' => 'aes']);
        $Mocker->getCryptManager()->setBlockCipher($newBlockCipher);
        $BlockCipher2  = $Mocker->getCryptManager()->getBlockCipher();
        $this->assertEquals($newBlockCipher, $BlockCipher2);
    }

    /**
     * ファイル暗号化
     */
    public function testFileCipher()
    {
        $Mocker     = ObjectManager::getSingleton()->get(Mocker::class);
        $FileCipher = $Mocker->getCryptManager()->getFileCipher();
        $this->assertInstanceOf(FileCipher::class, $FileCipher);
        // 新しいファイル暗号機構もセットできる
        $newFileCipher = new FileCipher();
        $Mocker->getCryptManager()->setFileCipher($newFileCipher);
        $FileCipher2  = $Mocker->getCryptManager()->getFileCipher();
        $this->assertEquals($newFileCipher, $FileCipher2);
    }

    public function testRandomString()
    {
        $Mocker     = ObjectManager::getSingleton()->get(Mocker::class);
        $RandomString = $Mocker->getCryptManager()->getRandomString();
        $this->assertTrue($RandomString instanceof RandomStringInterface);
        $newRandomString = new RandomString();
        $Mocker->getCryptManager()->setRandomString($newRandomString);
        $this->assertTrue($newRandomString === $Mocker->getCryptManager()->getRandomString());
    }
}
