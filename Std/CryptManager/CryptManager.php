<?php
/**
 * PHP version 7
 * File Std\CryptManager.php
 *
 * @category CryptManager
 * @package  Std\CryptManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\CryptManager;

use Laminas\Crypt\Password as ZendPassword;
use Laminas\Crypt\Password\PasswordInterface;
use Laminas\Crypt\BlockCipher;
use Laminas\Crypt\FileCipher;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\CryptManager\RandomStringInterface;
use Std\CryptManager\Secure\RandomString;
use Std\CryptManager\Password;

/**
 * 案件で暗号化に関係するメソッドを使用するためのクラス
 * 同名のAwareInterfaceとAwareTraitを対象クラスに継承することで使用可能
 * @category CryptManager
 * @package  Std\CryptManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class CryptManager implements
    ObjectManagerAwareInterface,
    ConfigManagerAwareInterface,
    CryptManagerInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Framework\ObjectManager\ObjectManagerAwareTrait;

    const DEFAULT_CRYPT_TYPE = 'Bcrypt';

    private $Crypt;
    private $BlockCipher;
    private $FileCipher;
    private $RandomString;

    public function createPasswordCrypt($passwordType = null)
    {
        $config         = $this->getConfigManager()->getConfig('crypt');
        if (!$passwordType) {
            $passwordType   = $config['password']['type'] ?? self::DEFAULT_CRYPT_TYPE;
        }
        $passwordCrypt  = 'Std\CryptManager\Password\\' . $passwordType;
        if (!class_exists($passwordCrypt)) {
            $passwordCrypt  = 'Laminas\Crypt\Password\\' . $passwordType;
        }
        assert(
            class_exists($passwordCrypt),
            sprintf('指定されているパスワード暗号化Crypt[ %s ]が有効ではありません。', $passwordCrypt)
        );
        return $this->getObjectManager()->get($passwordCrypt);
    }

    /**
     * {@inheritDoc}
     */
    public function getPasswordCrypt($passwordType = null) : PasswordInterface
    {
        if (null === $this->Crypt) {
            $this->Crypt = $this->createPasswordCrypt($passwordType);
        }
        return $this->Crypt;
    }

    /**
     * {@inheritDoc}
     */
    public function getBlockCipher($options = []) : BlockCipher
    {
        if (null === $this->BlockCipher) {
            $config      = $this->getConfigManager()->getConfig('crypt');
            $adapter     = $config['adapter'];
            $blockConfig = $config['block_cipher'];
            if (empty($options)) {
                $options = $blockConfig['options'];
            }
            $this->BlockCipher = BlockCipher::factory($adapter, $options);
            if (isset($blockConfig['encryption_key'])) {
                $this->BlockCipher->setKey($blockConfig['encryption_key']);
            }
        }
        return $this->BlockCipher;
    }

    /**
     * BlockCipher Setter
     *
     * @param BlockCipher $BlockCipher
     * @return void
     */
    public function setBlockCipher(BlockCipher $BlockCipher)
    {
        $this->BlockCipher = $BlockCipher;
    }

    /**
     * {@inheritDoc}
     */
    public function getFileCipher($options = []) : FileCipher
    {
        if (null === $this->FileCipher) {
            $config     = $this->getConfigManager()->getConfig('crypt');
            $FileConfig = $config['file_cipher'];
            $this->FileCipher = new FileCipher;
            if (isset($FileConfig['encryption_key'])) {
                $this->FileCipher->setKey($FileConfig['encryption_key']);
            }
        }
        return $this->FileCipher;
    }

    /**
     * FileCipher Setter
     *
     * @param FileCipher $FileCipher
     * @return void
     */
    public function setFileCipher(FileCipher $FileCipher)
    {
        $this->FileCipher = $FileCipher;
    }

    /**
     * ランダム文字列ジェネレータをセットする
     *
     * @param RandomStringInterface $RandomString
     * @return void
     */
    public function setRandomString(RandomStringInterface $RandomString)
    {
        $this->RandomString = $RandomString;
    }

    /**
     * ランダム文字列ジェネレータを取得する
     *
     * @return RandomStringInterface
     */
    public function getRandomString() : RandomStringInterface
    {
        if (null === $this->RandomString) {
            $this->RandomString = $this->getObjectManager()->get(RandomStringInterface::class, RandomString::class);
        }
        return $this->RandomString;
    }
}
