<?php
/**
 * PHP version 7
 * File CryptManagerInterface.php
 *
 * @category CryptManager
 * @package  Std\CryptManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\CryptManager;

use Laminas\Crypt\Password\PasswordInterface;
use Laminas\Crypt\BlockCipher;
use Laminas\Crypt\FileCipher;

/**
 * Interface CryptManager
 *
 * @category Interface
 * @package  Std\CryptManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface CryptManagerInterface
{
    /**
     * パスワードCrypt取得
     *
     * @return PasswordInterface
     */
    public function getPasswordCrypt() : PasswordInterface;

    /**
     * 文字列可逆暗号化機構取得
     *
     * @param array $options
     * @return BlockCipher
     */
    public function getBlockCipher($options = []) : BlockCipher;

    /**
     * ファイル可逆暗号化機構取得
     *
     * @param array $options
     * @return FileCipher
     */
    public function getFileCipher($options = []) : FileCipher;

    /**
     * ランダム文字列ジェネレータ
     *
     * @return RandomStringInterface
     */
    public function getRandomString() : RandomStringInterface;
}
