<?php
declare(strict_types=1);

namespace Project\Base\Front;

use Framework\EventManager\AbstractEventListenerManager;
use Framework\Application\ApplicationInterface;
use Framework\Application\HttpApplication;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\Controller\ControllerInterface;
use Std\RouterManager\RouterInterface;
use Std\RouterManager\Http\Router;
use Std\AclManager\AclManagerAwareInterface;
use Std\LoggerManager\LoggerManagerAwareInterface;
use Project\Base\Front\Controller\AbstractController;
use Project\Base\Front\Controller\ServerErrorController;

class EventListenerManager extends AbstractEventListenerManager implements
    HttpMessageManagerAwareInterface,
    AclManagerAwareInterface,
    ConfigManagerAwareInterface,
    LoggerManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use \Std\AclManager\AclManagerAwareTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\LoggerManager\LoggerManagerAwareTrait;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $this->getEventManager()
            ->addEventListener(
                ApplicationInterface::class,
                ApplicationInterface::TRIGGER_UNCAUGHT_EXCEPTION,
                [$this, 'handleUncatchedException']
            );
    }

    /**
     * 500ページを返す
     * 最小コードでコントローラからレスポンスを返すとサンプル
     *
     * @param [type] $event
     * @return void
     */
    public function handleUncatchedException($event)
    {
        ['Exception' => $exception] = $event->getData();
        $this->getLoggerManager()->get('error')->emergency($exception);
        $ServerErrorController = $this->getObjectManager()->create(ServerErrorController::class);
        // callActionFlowの中のイベントによりExceptionになっている可能性もある。
        // ここでは、callActionFlowをあえて使わない。
        $ViewModel = $ServerErrorController->index();
        $ServerErrorController->setViewModel($ViewModel);
        // イベントなしにてSystemErrorを描画する。
        $HttpMessageManager = $this->getHttpMessageManager();
        $HttpMessageManager->getResponse()->getBody()->write((string) $ViewModel->render());
        $HttpMessageManager->sendResponse();
    }
}
