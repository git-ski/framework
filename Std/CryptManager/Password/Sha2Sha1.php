<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Std\CryptManager\Password;

use Laminas\Crypt\Hash;
use Laminas\Crypt\Password\PasswordInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use InvalidArgumentException;
use RuntimeException;
use Laminas\Math\Rand;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Crypt\Utils;
use Traversable;

use function is_array;
use function hash;
use function hash_equals;
use function mb_strlen;
use function sprintf;
use function strtolower;

class Sha2Sha1 implements
    PasswordInterface,
    ConfigManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    const SHA1_SALT = 'DYhG93b0qyJfIxfs2guVoULulerniR2G0FgaC9mi';
    const SALT_SIZE = 10;

    /**
     * @var string
     */
    protected $cost = 1;

    /**
     * @var string
     */
    protected $salt;

    /**
     * password -> Sha1 -> Sha2
     *
     * @param  string $password
     * @throws RuntimeException
     * @return string
     */
    public function create($password)
    {
        $password = $this->prepareSha1($password);
        return $this->passwordHash($password);
    }

    /**
     * Verify if a password is correct against a hash value
     *
     * @param  string $password
     * @param  string $hash
     * @throws RuntimeException when the hash is unable to be processed
     * @return bool
     */
    public function verify($password, $hash)
    {
        $password = $this->prepareSha1($password);
        return $this->passwordVerify($password, $hash);
    }

    public function passwordHash($password, $salt = null)
    {
        if (null === $salt) {
            $salt = Rand::getString(self::SALT_SIZE);
        }
        $cost = (int) $this->cost;
        $hash = $password;
        while ($cost--) {
            $hash = Hash::compute('sha256', $hash);
        }
        return $salt . $hash;
    }

    public function passwordVerify($password, $hash)
    {
        $salt = substr($hash, 0, self::SALT_SIZE);
        $passwordHash = $this->passwordHash($password, $salt);
        // Utils::compareStrings で時間ベースアタックを対処する。
        return Utils::compareStrings($passwordHash, $hash);
    }

    private function prepareSha1($password)
    {
        $cryptConfig = $this->getConfigManager()->getConfig('crypt');
        $sha1salt = $cryptConfig['password']['options']['sha1salt'] ?? self::SHA1_SALT;
        return Hash::compute('sha1', $sha1salt . $password);
    }
}
