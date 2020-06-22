<?php
/**
 * PHP version 7
 * File SessionManagerAwareInterface.php
 *
 * @category Service
 * @package  Std
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\SessionManager;

use Std\SessionManager\SessionManager;

/**
 * Interface SessionManagerAwareInterface
 *
 * @category Interface
 * @package  Std
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait SessionManagerAwareTrait
{
    private static $SessionManager;

    /**
     * SessionManagerをセットする
     *
     * @param SessionManager $SessionManager SessionManager
     *
     * @return void
    */
    public function setSessionManager(SessionManager $SessionManager)
    {
        self::$SessionManager = $SessionManager;
    }

    /**
     * SessionManagerを取得する
     *
     * @return SessionManager $SessionManager
     */
    public function getSessionManager() : SessionManager
    {
        return self::$SessionManager;
    }
}
