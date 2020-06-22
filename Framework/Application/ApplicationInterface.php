<?php
/**
 * PHP version 7
 * File ApplicationInterface.php
 *
 * @category Module
 * @package  Framework\Application
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Framework\Application;

use Framework\EventManager\EventTargetInterface;

/**
 * Interface ApplicationInterface
 *
 * @category Application
 * @package  Framework\Application
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ApplicationInterface extends EventTargetInterface
{
    // Event
    const TRIGGER_BEFORE_BUILD_RESPONSE = 'before.build.reponse';
    const TRIGGER_AFTER_BUILD_RESPONSE  = 'after.build.reponse';
    const TRIGGER_UNCAUGHT_EXCEPTION   = 'uncaught.exception';

    /**
     * コントローラを介してビューを返す一連の処理を行う。
     *
     * @return void
     */
    public function run();

    /**
     * 終了時イベントを発火させてプログラムを終了する。
     *
     * @return void
     */
    public function exit();
}
