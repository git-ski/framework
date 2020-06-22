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
use Laminas\Crypt\Password\Bcrypt;
use Framework\ConfigManager\ConfigManagerAwareInterface;

/**
 * Bcrypt algorithm using crypt() function of PHP with password
 * hashed using SHA2 to allow for passwords >72 characters.
 */
class BcryptSha1 extends Bcrypt implements
    ConfigManagerAwareInterface
{
    const SHA1_SALT = 'DYhG93b0qyJfIxfs2guVoULulerniR2G0FgaC9mi';

    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    /**
     * BcryptSha
     *
     * @param  string $password
     * @throws Exception\RuntimeException
     * @return string
     */
    public function create($password)
    {
        $password = $this->addSalt($password);
        return parent::create(Hash::compute('sha1', $password));
    }

    /**
     * Verify if a password is correct against a hash value
     *
     * @param  string $password
     * @param  string $hash
     * @throws Exception\RuntimeException when the hash is unable to be processed
     * @return bool
     */
    public function verify($password, $hash)
    {
        $password = $this->addSalt($password);
        return parent::verify(Hash::compute('sha1', $password), $hash);
    }

    private function addSalt($password)
    {
        $cryptConfig = $this->getConfigManager()->getConfig('crypt');
        $sha1salt = $cryptConfig['password']['options']['sha1salt'] ?? self::SHA1_SALT;
        return $sha1salt . $password;
    }
}
