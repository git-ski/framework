<?php
/**
 * PHP version 7
 * File HttpMessageManager.php
 *
 * @category HttpMessageManager
 * @package  Std\HttpMessageManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\HttpMessageManager;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Stream;
use ParagonIE\CSPBuilder\CSPBuilder;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

/**
 * Interface HttpMessageManager
 *
 * @category Interface
 * @package  Std\HttpMessageManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class HttpMessageManager implements
    HttpMessageManagerInterface,
    ConfigManagerAwareInterface
{
    use \Framework\EventManager\EventTargetTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    private $request    = null;
    private $response   = null;
    private $emitter    = null;
    private $cspBuilder = null;
    private $nonce      = null;

    /**
     * {@inheritdoc}
     */
    public function getRequest() : ServerRequestInterface
    {
        if ($this->request === null) {
            $this->request = ServerRequestFactory::fromGlobals(
                $_SERVER,
                $_GET,
                $_POST,
                $_COOKIE,
                $_FILES
            );
        }
        return $this->request;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse() : ResponseInterface
    {
        if ($this->response === null) {
            $this->response = new Response();
        }
        return $this->response;
    }

    /**
     * {@inheritdoc}
     */
    public function setResponse(ResponseInterface $Response)
    {
        $this->response = $Response;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function sendResponse()
    {
        $this->triggerEvent(self::TRIGGER_BEFORE_SEND_RESPONSE);
        $Response = $this->getResponse();
        $this->_getEmitter()->emit($Response);
        $this->triggerEvent(self::TRIGGER_AFTER_SEND_RESPONSE);
    }

    private function _getEmitter()
    {
        if (!$this->emitter) {
            $this->emitter = new SapiEmitter();
        }
        return $this->emitter;
    }

    /**
     * {@inheritdoc}
     */
    public function createStream($content) : StreamInterface
    {
        if ($content instanceof StreamInterface) {
            return $content;
        }
        if (! is_string($content)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid content (%s) provided to %s',
                (is_object($content) ? get_class($content) : gettype($content)),
                __CLASS__
            ));
        }
        $Stream = new Stream('php://temp', 'wb+');
        $Stream->write($content);
        $Stream->rewind();
        return $Stream;
    }

    /**
     * {@inheritdoc}
     */
    public function getNonce() : string
    {
        if (null === $this->nonce) {
            $this->getCspBuilder();
        }
        return $this->nonce;
    }

    public function getCspBuilder() : CSPBuilder
    {
        if (null === $this->cspBuilder) {
            $config = $this->getConfigManager()->getConfig('secure');
            $cspConfig = $config['content_security_policy'] ?? [];
            $this->cspBuilder = new CSPBuilder($cspConfig);
            $this->nonce = $this->cspBuilder->nonce();
            $this->cspBuilder->nonce('style-src', $this->nonce);
        }
        return $this->cspBuilder;
    }
}
