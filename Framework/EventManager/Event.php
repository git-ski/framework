<?php
/**
 * PHP version 7
 * File Event.php
 *
 * @category Event
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\EventManager;

/**
 * Class Event
 *
 * @category Class
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Event
{
    private $name             = null;
    private $data             = null;
    private $target           = null;
    private $defaultPrevented = false;
    private $bubbles          = true;
    private $cancelable       = true;

    /**
     * Constructor
     *
     * @param string $name   EventName
     * @param array  $config EventConfig
     */
    public function __construct($name, $config = [])
    {
        $this->name         = $name;
        $this->cancelable   = $config['cancelable'] ?? true;
        $this->bubbles      = $config['bubbles'] ?? true;
    }

    /**
     * Method getName
     *
     * @return string $eventName
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Method setData
     *
     * @param mixed $data EventData
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Method getData
     *
     * @return mixed $eventData
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Method setTarget
     *
     * @param EventTargetInterface|EventTargetTrait $target EventTarget
     *
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    /**
     * Method getTarget
     *
     * @return EventTargetInterface $eventTarget
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Method isDefaultPrevented
     *
     * @return boolean
     */
    public function isDefaultPrevented()
    {
        return $this->defaultPrevented;
    }

    /**
     * Method isBubbles
     *
     * @return boolean
     */
    public function isBubbles()
    {
        return $this->bubbles;
    }

    /**
     * Method preventDefault
     *
     * @return $this
     */
    public function preventDefault()
    {
        if ($this->cancelable) {
            $this->defaultPrevented = true;
        }
        return $this;
    }

    /**
     * Method stopPropagation
     *
     * @return $this
     */
    public function stopPropagation()
    {
        if ($this->cancelable) {
            $this->bubbles = false;
        }
        return $this;
    }

    /**
     * Method stopImmediatePropagation
     *
     * @return $this
     */
    public function stopImmediatePropagation()
    {
        if ($this->cancelable) {
            $this->defaultPrevented = true;
            $this->bubbles = false;
        }
        return $this;
    }

    /**
     * Method resetDefaultPrevent
     *
     * @return $this
     */
    public function resetDefaultPrevent()
    {
        $this->defaultPrevented = false;
        return $this;
    }
}
