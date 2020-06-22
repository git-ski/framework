<?php
/**
 * PHP version 7
 * File EventTargetInterface.php
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
 * イベントの発火状況をEventManagerに伝達するためのクラス
 *
 * @category Interface
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface EventTargetInterface
{
    const TRIGGER_INIT   = "Initiation";
    const TRIGGER_INITED = "Initialized";
    const TRIGGER_DEINIT = "Deinitiation";

    /**
     * Method addEventListener
     *
     * @param string   $eventName EventName
     * @param callable $listener  Listener
     *
     * @return mixed
     */
    public function addEventListener($eventName, callable $listener);

    /**
     * Method removeEventListener
     *
     * @param string   $eventName EventName
     * @param callable $listener  Listener
     *
     * @return mixed
     */
    public function removeEventListener($eventName, callable $listener);

    /**
     * Method dispatchEvent
     *
     * @param Event $event Event
     *
     * @return mixed
     */
    public function dispatchEvent(Event $event);

    /**
     * Method getEventListeners
     *
     * @param string|Event $event   EventOrName
     * @param string|null  $trigger triggerName
     *
     * @return array Listeners
     */
    public function getEventListeners($event, $trigger = null): array;

    /**
     * Method triggerEvent
     *
     * @param string $event      EventName
     * @param mixed  $parameters EventData
     *
     * @return $this
     */
    public function triggerEvent($event, $parameters = []);
}
