<?php
/**
 * PHP version 7
 * File HttpApplication.php
 *
 * @category Module
 * @package  Framework\Application
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\Application;

use Std\Controller\ControllerInterface;
use Std\RouterManager\RouterManagerAwareInterface;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Throwable;

/**
 * Class HttpApplication
 *
 * @category Application
 * @package  Framework\Application
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class HttpApplication extends AbstractApplication implements
    RouterManagerAwareInterface,
    HttpMessageManagerAwareInterface
{
    use \Std\RouterManager\RouterManagerAwareTrait;
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        try {
            $Router = $this->getRouterManager()->getMatched();
            if ($Router->isFaviconRequest()) {
                return $this->sendDummyFavicon();
            }
            $request    = $Router->dispatch();
            $Controller = $this->getObjectManager()->get(ControllerInterface::class, $request['controller']);
            if (!$Controller instanceof ControllerInterface) {
                $Controller = $this->getObjectManager()->get(ControllerInterface::class);
            }
            assert(
                $Controller instanceof ControllerInterface,
                "システム上Controllerは存在しない、適切なモジュールをインストールされていることを確認ください。"
            );
            $ViewModel = $Controller->callActionFlow($request['action'], $request['param']);
            $HttpMessageManager = $this->getHttpMessageManager();
            $this->triggerEvent(self::TRIGGER_BEFORE_BUILD_RESPONSE);
            $content = $ViewModel->render();
            $HttpMessageManager->getResponse()->getBody()->write((string) $content);
            $this->triggerEvent(self::TRIGGER_AFTER_BUILD_RESPONSE);
            $HttpMessageManager->sendResponse();
            $this->exit();
        } catch (Throwable $e) {
            $this->triggerEvent(self::TRIGGER_UNCAUGHT_EXCEPTION, ['Exception' => $e]);
        }
    }

    /**
     * ダミーのfaviconデータを送信する。
     * ※faviconを設定しない場合に発生する処理をスキップするため
     *
     * @return void
     */
    public function sendDummyFavicon()
    {
        $HttpMessageManager = $this->getHttpMessageManager();
        $Response = $HttpMessageManager->getResponse();
        $Response = $Response->withHeader('Content-Type', 'image/vnd.microsoft.icon');
        $Response = $Response->withHeader('Content-length', '0');
        $HttpMessageManager->setResponse($Response)
            ->sendResponse();
    }
}
