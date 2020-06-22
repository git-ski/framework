<?php
/**
 * PHP version 7
 * File EventListenerManager.php
 *
 * @category EventListener
 * @package  Std\Logger
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\HttpMessageManager;

use Framework\EventManager\EventManagerAwareInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Std\HttpMessageManager\HttpMessageManagerInterface;
use Std\Controller\ControllerInterface;
use Std\Restful\RestfulInterface;

/**
 * class EventListenerManager
 *
 * @category EventListener
 * @package  Std\Logger
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class EventListenerManager implements
    ObjectManagerAwareInterface,
    EventManagerAwareInterface,
    HttpMessageManagerAwareInterface,
    ConfigManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Framework\EventManager\EventManagerAwareTrait;
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
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
                HttpMessageManagerInterface::class,
                HttpMessageManagerInterface::TRIGGER_BEFORE_SEND_RESPONSE,
                [$this, 'injectResponseHeader']
            );
    }

    public function injectResponseHeader($event)
    {
        $HttpMessageManager = $event->getTarget();
        $Response = $HttpMessageManager->getResponse();
        $Response = $HttpMessageManager->getCspBuilder()->injectCSPHeader($Response);
        $Response = $this->injectSecureHeader($Response);
        $HttpMessageManager->setResponse($Response);
    }

    private function injectSecureHeader($Response)
    {
        $config = $this->getConfigManager()->getConfig('secure');
        $httpResponseHeader = $config['http_response']['header'] ?? [];
        foreach ($httpResponseHeader as $key => $value) {
            $Response = $Response->withHeader($key, $value);
        }
        $Controller = $this->getObjectManager()->get(ControllerInterface::class);
        if ($Controller instanceof RestfulInterface) {
            $restResponseHeader = $config['restful']['header'] ?? [];
            foreach ($restResponseHeader as $key => $value) {
                $Response = $Response->withHeader($key, $value);
            }
        }
        return $Response;
    }
}
