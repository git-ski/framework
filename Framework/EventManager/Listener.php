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
class Listener
{
    private $listener;
    private $priority;

    public function __construct(callable $listener, $priority = 1)
    {
        $this->listener = $listener;
        $this->priority = $priority;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function __invoke(...$arg)
    {
        return call_user_func_array($this->listener, $arg);
    }

    public function equal(callable $listener)
    {
        return $this->listener === $listener;
    }
}
