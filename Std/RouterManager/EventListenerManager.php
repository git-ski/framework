<?php
/**
 * PHP version 7
 * File EventListenerManager.php
 *
 * @category EventListener
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\RouterManager;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\EventManager\EventManagerInterface;
use Framework\EventManager\EventTargetInterface;
use Framework\Application\HttpApplication;
use Framework\Application\ConsoleApplication;
use Std\RouterManager\RouterManagerAwareInterface;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Std\Authentication\AuthenticationInterface;

/**
 * class EventListenerManager
 *
 * @category EventListener
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class EventListenerManager implements
    ObjectManagerAwareInterface,
    HttpMessageManagerAwareInterface,
    RouterManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\RouterManager\RouterManagerAwareTrait;
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $this->getObjectManager()->get(EventManagerInterface::class)
            ->addEventListener(
                HttpApplication::class,
                EventTargetInterface::TRIGGER_INITED,
                [$this, 'redirectToSsl']
            )
            ->addEventListener(
                HttpApplication::class,
                EventTargetInterface::TRIGGER_INITED,
                [$this, 'exportHttpRouter']
            )
            ->addEventListener(
                ConsoleApplication::class,
                EventTargetInterface::TRIGGER_INITED,
                [$this, 'exportConsoleRouter']
            )
            ->addEventListener(
                AuthenticationInterface::class,
                AuthenticationInterface::TRIGGER_AUTHENTICATE,
                [$this, 'resetRedirectHistory']
            );
    }

    public function exportHttpRouter()
    {
        $this->getObjectManager()->get(RouterManagerInterface::class)
            ->register(
                __NAMESPACE__,
                $this->getObjectManager()->create(Http\Router::class)
            );
    }

    public function exportConsoleRouter()
    {
        $this->getObjectManager()->get(RouterManagerInterface::class)
            ->register(
                __NAMESPACE__,
                $this->getObjectManager()->create(Console\Router::class)
            );
    }

    public function redirectToSsl(\Framework\EventManager\Event $event)
    {
        $HttpMessageManager = $this->getHttpMessageManager();
        $Request = $HttpMessageManager->getRequest();
        $Uri = $Request->getUri();
        if ('https' !== $Uri->getScheme()) {
            $Response = new RedirectResponse($Uri->withScheme('https'));
            $HttpMessageManager->setResponse($Response)
                ->sendResponse();
                $HttpApplication = $event->getTarget();
                assert($HttpApplication instanceof HttpApplication);
            $HttpApplication->exit();
        }
    }

    public function resetRedirectHistory(\Framework\EventManager\Event $event)
    {
        $this->getObjectManager()->get(RouterManagerInterface::class)
            ->getMatched()->resetRedirectHistory();
    }
}
