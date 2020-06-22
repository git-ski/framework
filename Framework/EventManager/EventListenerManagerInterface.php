<?php
/**
 * PHP version 7
 * File EventManagerInterface.php
 *
 * @category Interface
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\EventManager;

/**
 * Interface EventManagerInterface
 *
 * @category Interface
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface EventListenerManagerInterface
{
    /**
     * Listenerを初期化する
     *
     * @return void
     */
    public function initListener();
}
