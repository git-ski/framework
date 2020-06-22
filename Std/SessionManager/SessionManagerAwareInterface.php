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

/**
 * Interface SessionManagerAwareInterface
 *
 * @category Interface
 * @package  Std
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface SessionManagerAwareInterface
{
    /**
     * SessionManagerをセットする
     *
     * @param SessionManager $SessionManager SessionManager
     *
     * @return mixed
     */
    public function setSessionManager(SessionManager $SessionManager);

    /**
     * SessionManagerを取得する
     *
     * @return SessionManager $SessionManager
     */
    public function getSessionManager() : SessionManager;
}
