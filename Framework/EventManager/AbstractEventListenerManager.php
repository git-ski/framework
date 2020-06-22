<?php
/**
 * PHP version 7
 * File Framework\EventManager\AbstractEventListenerManager.php
 *
 * @category EventListenerManager
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\EventManager;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\EventManager\EventManagerAwareInterface;
use Framework\EventManager\EventListenerManagerInterface;

/**
 * Class AbstractEventListenerManager
 *
 * @category EventListenerManager
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
abstract class AbstractEventListenerManager implements
    EventListenerManagerInterface,
    ObjectManagerAwareInterface,
    EventManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Framework\EventManager\EventManagerAwareTrait;

    /**
     * {@inheritDoc}
     */
    abstract public function initListener();
}
