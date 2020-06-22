<?php
declare(strict_types=1);

namespace Project\Base\Api;

use Framework\EventManager\AbstractEventListenerManager;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Std\Controller\ControllerInterface;
use Std\LoggerManager\LoggerManagerAwareInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\Restful\AbstractRestfulController;
use Std\Restful\RestfulInterface;
use Laminas\Diactoros\Request\ArraySerializer as RequestSerializer;
use Laminas\Diactoros\Response\ArraySerializer as ResponseSerializer;

class EventListenerManager extends AbstractEventListenerManager implements
    HttpMessageManagerAwareInterface,
    LoggerManagerAwareInterface,
    ConfigManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use \Std\LoggerManager\LoggerManagerAwareTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    const EXCEPT_KEYS = [
        'password', 'card', 'payment', 'session', 'accessId', 'accessPass'
    ];

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $config = $this->getConfigManager()->getConfig('application');
        $silence_api_log = $config['silence_api_log'] ?? true;
        if ($silence_api_log) {
            return ;
        }
        $this->getEventManager()
            ->addEventListener(
                AbstractRestfulController::class,
                ControllerInterface::TRIGGER_BEFORE_ACTION,
                [$this, 'logRequest']
            )
            ->addEventListener(
                AbstractRestfulController::class,
                ControllerInterface::TRIGGER_AFTER_ACTION,
                [$this, 'logResponse']
            );
    }

    public function logRequest(\Framework\EventManager\Event $event)
    {
        $Controller = $event->getTarget();
        $logger = $this->getLoggerManager()->get('api');
        $Request = $this->getHttpMessageManager()->getRequest();
        $request = ['body' => null] + RequestSerializer::toArray($Request);
        if ($Controller->requestHasContentType($Request, RestfulInterface::CONTENT_TYPE_JSON)) {
            $request['post'] = json_decode((string) $Request->getBody());
        } else {
            $request['post'] = $Request->getParsedBody();
        }
        $request['post'] = $this->filterSensitiveData($request['post']);
        $request['get'] = $Request->getQueryParams();
        $requesrData = [
            'identification' => spl_object_hash($Controller),
            'uri' => (string) $Request->getUri(),
            'request' => $request,
        ];
        $logger->info('api request', $requesrData);
    }

    public function logResponse(\Framework\EventManager\Event $event)
    {
        $Controller = $event->getTarget();
        $logger = $this->getLoggerManager()->get('api');
        $Request = $this->getHttpMessageManager()->getRequest();
        $response = [
            'identification' => spl_object_hash($Controller),
            'uri' => (string) $Request->getUri(),
            'response' => $Controller->getViewModel()->getData()
        ];
        $logger->info('api response', $response);
    }

    public function filterSensitiveData($data)
    {
        if (!is_array($data)) {
            return $data;
        }
        foreach ($data as $index => $item) {
            if (in_array($index, self::EXCEPT_KEYS)) {
                unset($data[$index]);
            }
            $data[$index] = $this->filterSensitiveData($item);
        }
        return $data;
    }
}
