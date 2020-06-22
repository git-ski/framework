<?php
/**
 * PHP version 7
 * File AbstractAdapter.php
 *
 * @category Authentication
 * @package  Std\Authentication
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\Authentication\Adapter;

use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Crypt\Password\PasswordInterface;
use Std\CryptManager\CryptManagerAwareInterface;

/**
 * Class AbstractAdapter
 *
 * @category Class
 * @package  Std\Authentication
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
abstract class AbstractAdapter implements
    CryptManagerAwareInterface,
    AdapterInterface
{
    use \Std\CryptManager\CryptManagerAwareTrait;

    protected $username;
    protected $password;

    /**
     * Method __construct
     *
     * @param string|null $username UserName
     * @param string|null $password Password
     */
    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * ユーザ名をセットする
     *
     * @param string $username ユーザ名
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * ユーザ名を取得する
     *
     * @return string username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * パスワードをセットする
     *
     * @param string $password パスワード
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * パスワードを取得する
     *
     * @return string password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * 認証を行う
     *
     * @return \Laminas\Authentication\Result
     * @throws \Laminas\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    abstract public function authenticate();

    /**
     * CryptManagerからCryptオブジェクトを取得する
     *
     * @return PasswordInterface
     */
    public function getCrypt() : PasswordInterface
    {
        return $this->getCryptManager()->getPasswordCrypt();
    }
}
