<?php
/**
 * PHP version 7
 * File EventManager.php
 *
 * @category EventManager
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\EventManager;

use Framework\ObjectManager\ObjectManager;
use Framework\ObjectManager\SingletonInterface;
use Framework\Application\ApplicationInterface;
use Std\CacheManager\CacheManagerAwareInterface;
use Framework\EventManager\Listener;

/**
 * Class EventManager
 *
 * @category Class
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class EventManager implements
    EventManagerInterface,
    CacheManagerAwareInterface,
    SingletonInterface
{
    use \Framework\ObjectManager\SingletonTrait;
    use \Std\CacheManager\CacheManagerAwareTrait;

    const ERROR_EVENT_STACK_EXISTS            = "error: event [%s] is loop-triggered in class [%s]'s eventStack;";
    const ERROR_UNDEFINED_EVENT_TRIGGER       = "error: undefiend event trigger [%s] in class [%s]";
    const ERROR_INVALID_CALLBACK_ADD_EVENT    = "error: invalid callback with add event [%s]";
    const ERROR_INVALID_CALLBACK_REMOVE_EVENT = "error: invalid callback with remove event [%s]";

    private $eventQueue           = [];
    private $triggerScope         = [];
    private $triggerPool          = null;
    private $propagationChainPool = [];

    public function __construct()
    {
        ObjectManager::getSingleton()->injectDependency($this);
    }

    /**
     * {@inheritDoc}
     */
    public function addEventListener($class, $event, callable $listener, $priority = 1)
    {
        $trigger = $this->getTrigger($class, $event);
        if (!isset($this->eventQueue[$trigger])) {
            $this->eventQueue[$trigger] = [];
        }
        $this->eventQueue[$trigger][] = new Listener($listener, $priority);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeEventListener($class, $event, callable $listener)
    {
        $trigger = $this->getTrigger($class, $event);
        if (!isset($this->eventQueue[$trigger])) {
            return $this;
        }
        foreach ($this->eventQueue[$trigger] as $key => $call) {
            if ($call->equal($listener)) {
                unset($this->eventQueue[$trigger][$key]);
                break;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getEventListeners($class, $event, $sort = false)
    {
        if ($class instanceof EventTargetInterface) {
            return $class->getEventListeners($event, null, $sort);
        }
        $trigger = $this->getTrigger($class, $event);
        if (empty($trigger)) {
            return [];
        }
        if (!isset($this->eventQueue[$trigger])) {
            $this->eventQueue[$trigger] = [];
        }
        if ($sort) {
            usort($this->eventQueue[$trigger], function (Listener $before, Listener $after) {
                return $before->getPriority() <= $after->getPriority() ? -1 : 1;
            });
        }
        return $this->eventQueue[$trigger];
    }

    /**
     * {@inheritDoc}
     */
    public function dispatchEvent($class, Event $Event)
    {
        if (in_array($Event, $this->triggerScope)) {
            throw new \LogicException(sprintf(self::ERROR_EVENT_STACK_EXISTS, $Event->getName(), $class));
        }
        $this->triggerScope[] = $Event;
        foreach (self::getPropagationChain($class) as $propagation) {
            if ($Event->isBubbles() === false && $propagation !== $class) {
                break;
            }
            foreach ($this->getEventListeners($propagation, $Event, true) as $call) {
                if ($Event->isDefaultPrevented()) {
                    $Event->resetDefaultPrevent();
                    break;
                }
                call_user_func($call, $Event);
            }
        }
        return array_pop($this->triggerScope);
    }

    /**
     * Method dispatchTargetEvent
     *
     * @param EventTargetInterface $target      EventTarget
     * @param string               $targetClass EventTargetClass
     * @param Event                $Event       Event
     *
     * @return string triggerScope
     */
    public function dispatchTargetEvent(EventTargetInterface $target, $targetClass, Event $Event)
    {
        if (in_array($Event, $this->triggerScope)) {
            throw new \LogicException(sprintf(self::ERROR_EVENT_STACK_EXISTS, $Event->getName(), $targetClass));
        }
        $this->triggerScope[] = $Event;
        $trigger = $this->getTrigger($targetClass, $Event);
        if (!empty($trigger)) {
            foreach ($target->getEventListeners($Event->getName(), $trigger, true) as $call) {
                if ($Event->isDefaultPrevented()) {
                    $Event->resetDefaultPrevent();
                    break;
                }
                call_user_func($call, $Event);
            }
        }
        array_pop($this->triggerScope);
        return $this->dispatchEvent($targetClass, $Event);
    }

    /**
     * Method getCurrentEvent
     *
     * @return Event|null $event
     */
    public function getCurrentEvent()
    {
        $triggerScopeLength = count($this->triggerScope) - 1;
        return $this->triggerScope[$triggerScopeLength] ? $this->triggerScope[$triggerScopeLength] : null;
    }

    /**
     * Method getTrigger
     *
     * @param string       $class ClassName
     * @param string|Event $event EventName
     *
     * @return string TriggerName
     */
    public function getTrigger($class, $event)
    {
        if ($event instanceof Event) {
            $event = $event->getName();
        }
        $_triggerPool = $this->initTrigger($class);
        if (isset($_triggerPool[$event])) {
            return $_triggerPool[$event];
        }
        return '';
    }

    /**
     * Method initTrigger
     *
     * @param string $class ClassName
     *
     * @return array eventTriggers
     */
    public function initTrigger($class)
    {
        if (!isset($this->triggerPool[$class])) {
            $reflection   = new \ReflectionClass($class);
            $eventTrigger = [];
            foreach ($reflection->getConstants() as $constantName => $val) {
                //TRIGGER_が始まるトリッガを拾う
                if (strpos($constantName, 'TRIGGER_') === 0) {
                    //クラス情報をトリッガにセットする
                    $eventTrigger[$val] = $class . "::" . $val;
                }
            }
            $this->triggerPool[$class] = $eventTrigger;
        }
        return $this->triggerPool[$class];
    }

    /**
     * Method getPropagationChain
     *
     * @param string $class ClassName
     *
     * @return array propagationChains
     */
    public function getPropagationChain($class)
    {
        if (!isset($this->propagationChainPool[$class])) {
            $this->propagationChainPool[$class] = [$class] + class_parents($class) + class_implements($class);
        }
        return $this->propagationChainPool[$class];
    }

    /**
     * Method createEvent
     *
     * @param string $name EventName
     *
     * @return Event $event
     */
    public function createEvent($name)
    {
        return new Event($name);
    }
}
