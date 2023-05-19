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

namespace Project\History\Admin;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\EventManager\EventManagerInterface;
use Project\Base\Admin\Controller\AbstractAdminController;
use Project\AdminUser\Admin\Authentication\AuthenticationAwareInterface;
use Project\History\Helper\OperationHelper;

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
                AbstractAdminController::class,
                AbstractAdminController::TRIGGER_AFTER_CREATE,
                [$this, 'onAdminOperation']
            )
            ->addEventListener(
                AbstractAdminController::class,
                AbstractAdminController::TRIGGER_AFTER_UPDATE,
                [$this, 'onAdminOperation']
            )
            ->addEventListener(
                AbstractAdminController::class,
                AbstractAdminController::TRIGGER_AFTER_DELETE,
                [$this, 'onAdminOperation']
            );
    }

    public function onAdminOperation(\Framework\EventManager\Event $event)
    {
        $Identity = $this->getAuthentication()->getIdentity();
        $OperationHelper = $this->getObjectManager()->get(OperationHelper::class);
        $OperationHelper->logAuthOperation($event->getName(), $event->getData());
        $OperationHelper->logAdminOperation($event->getName(), $event->getData(), $Identity);
    }
}
