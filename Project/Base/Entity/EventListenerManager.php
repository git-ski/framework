<?php
declare(strict_types=1);

namespace Project\Base\Entity;

use Framework\EventManager\AbstractEventListenerManager;
use Framework\Application\AbstractApplication;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\AclManager\AclManagerAwareInterface;
use Std\LoggerManager\LoggerManagerAwareInterface;
use Std\EntityManager\FactoryInterface;
use Std\EntityManager\EntityInterface;
use Doctrine\DBAL\Logging\DebugStack;

class EventListenerManager extends AbstractEventListenerManager implements
    AclManagerAwareInterface,
    LoggerManagerAwareInterface,
    ConfigManagerAwareInterface
{
    use \Std\AclManager\AclManagerAwareTrait;
    use \Std\LoggerManager\LoggerManagerAwareTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $this->getEventManager()
            ->addEventListener(
                FactoryInterface::class,
                FactoryInterface::TRIGGER_ENTITY_MANAGER_CREATED,
                [$this, 'wrapTransaction']
            );
    }

    public function wrapTransaction($event)
    {
        ['EntityManager' => $EntityManager] = $event->getData();
        $EntityConfiguration = $EntityManager->getConfiguration();
        $Config = $this->getConfigManager()->getConfig('model');
        $customFunctions = $Config['custom_functions'] ?? [];
        foreach ($customFunctions as $name => $namespace) {
            $EntityConfiguration->addCustomStringFunction($name, $namespace);
        }
        $EntityManager->beginTransaction();
        $this->getEventManager()
            ->addEventListener(
                AbstractApplication::class,
                AbstractApplication::TRIGGER_DEINIT,
                function () use ($EntityManager) {
                    $EntityManager->commit();
                }
            );
    }
}
