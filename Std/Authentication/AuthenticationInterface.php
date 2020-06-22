<?php
/**
 * PHP version 7
 * File AuthenticationInterface.php
 *
 * @category Authentication
 * @package  Std\Authentication
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\Authentication;

use Framework\EventManager\EventTargetInterface;

/**
 * Interface AuthenticationInterface
 *
 * @category Authentication
 * @package  Std\Authentication
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface AuthenticationInterface extends EventTargetInterface
{
    const TRIGGER_AUTHENTICATE = 'authenticate';

    /**
     * 認証を行う
     *
     * @param string $username ユーザ名
     * @param string $password パスワード
     *
     * @return void
     */
    public function login($username, $password);

    /**
     * 認証IDを追加する
     *
     * @param array $Identity ID
     *
     * @return void
     */
    public function updateIdentity(array $Identity);
}
