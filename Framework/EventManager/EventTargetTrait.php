<?php
/**
 * PHP version 7
 * File EventTargetTrait.php
 *
 * @category Interface
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\EventManager;

use Framework\ObjectManager\ObjectManager;
use Framework\EventManager\Listener;

/**
 * イベントの発火状況をEventManagerに伝達するためのクラス
 *
 * @category Trait
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait EventTargetTrait
{
    private $eventListeners = [];

    /**
     * Method addEventListener
     *
     * @param string   $event    EventName
     * @param callable $listener Listener
     *
     * @return void
     */
    public function addEventListener($event, callable $listener, $priority = 1)
    {
        $trigger = $this->_getTrigger($event);
        if (!isset($this->eventListeners[$trigger])) {
            $this->eventListeners[$trigger] = [];
        }
        $this->eventListeners[$trigger][] = new Listener($listener, $priority);
    }

    /**
     * Method removeEventListener
     *
     * @param string   $event    EventName
     * @param callable $listener Listener
     *
     * @return void
     */
    public function removeEventListener($event, callable $listener)
    {
        $trigger = $this->_getTrigger($event);
        if (!isset($this->eventListeners[$trigger])) {
            $this->eventListeners[$trigger] = [];
        }
        foreach ($this->eventListeners[$trigger] as $key => $call) {
            if ($call->equal($listener)) {
                unset($this->eventListeners[$trigger][$key]);
                break;
            }
        }
    }

    /**
     * Method getEventListeners
     *
     * @param string|Event $event   EventOrName
     * @param string|null  $trigger triggerName
     *
     * @return array Listeners
     */
    public function getEventListeners($event, $trigger = null, $sort = false): array
    {
        $trigger = $trigger ? $trigger : $this->_getTrigger($event);
        if (empty($trigger)) {
            return [];
        }
        if (!isset($this->eventListeners[$trigger])) {
            $this->eventListeners[$trigger] = [];
        }
        if ($sort) {
            usort($this->eventListeners[$trigger], function (Listener $before, Listener $after) {
                return $before->getPriority() <= $after->getPriority() ? -1 : 1;
            });
        }
        return $this->eventListeners[$trigger];
    }

    /**
     * Method dispatchEvent
     *
     * @param Event $Event Event
     *
     * @return void
     */
    public function dispatchEvent(Event $Event)
    {
        assert($this instanceof EventTargetInterface);
        $Event->setTarget($this);
        ObjectManager::getSingleton()
            ->get(EventManagerInterface::class)
            ->dispatchTargetEvent($this, static::class, $Event);
    }

    /**
     * Method triggerEvent
     *
     * @param string $event      EventName
     * @param mixed  $parameters EventData
     *
     * @return $this
     */
    public function triggerEvent($event, $parameters = [])
    {
        $Event = ObjectManager::getSingleton()
                    ->get(EventManagerInterface::class)
                    ->createEvent($event);
        $Event->setData($parameters);
        $this->dispatchEvent($Event);
        return $this;
    }

    /**
     * Method getCurrentEvent
     *
     * @return Event|null $event;
     */
    public function getCurrentEvent()
    {
        return ObjectManager::getSingleton()
                    ->get(EventManagerInterface::class)
                    ->getCurrentEvent();
    }

    /**
     * Method _getTrigger
     *
     * @param string|Event $event EventOrName
     *
     * @return string
     */
    private function _getTrigger($event): string
    {
        return ObjectManager::getSingleton()
                    ->get(EventManagerInterface::class)
                    ->getTrigger(static::class, $event);
    }
}
