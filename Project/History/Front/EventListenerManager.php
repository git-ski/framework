<?php
/**
 * PHP version 7
 * File EventListenerManager.php
 *
 * @category EventListener
 * @package  Project\History
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\History\Front;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\EventManager\EventManagerInterface;
use Project\Base\Front\Controller\AbstractController;
use Project\History\Helper\OperationHelper;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;

/**
 * class EventListenerManager
 *
 * @category EventListener
 * @package  Project\History
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EventListenerManager implements
    ObjectManagerAwareInterface,
    AuthenticationAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\Authentication\AuthenticationAwareTrait;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $this->getObjectManager()->get(EventManagerInterface::class)
            ->addEventListener(
                AbstractController::class,
                AbstractController::TRIGGER_AFTER_CREATE,
                [$this, 'onFrontOperation']
            )
            ->addEventListener(
                AbstractController::class,
                AbstractController::TRIGGER_AFTER_UPDATE,
                [$this, 'onFrontOperation']
            )
            ->addEventListener(
                AbstractController::class,
                AbstractController::TRIGGER_AFTER_DELETE,
                [$this, 'onFrontOperation']
            );
    }

    public function onFrontOperation(\Framework\EventManager\Event $event)
    {
        $Identity = $this->getAuthentication()->getIdentity();
        $OperationHelper = $this->getObjectManager()->get(OperationHelper::class);
        $OperationHelper->logAuthOperation($event->getName(), $event->getData());
        $OperationHelper->logCustomerOperation($event->getName(), $event->getData(), $Identity);
    }
}
