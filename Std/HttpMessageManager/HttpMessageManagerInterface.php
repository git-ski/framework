<?php
/**
 * PHP version 7
 * File HttpMessageManagerInterface.php
 *
 * @category HttpMessageManager
 * @package  Std\HttpMessageManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\HttpMessageManager;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Framework\EventManager\EventTargetInterface;

/**
 * Interface HttpMessageManagerInterface
 *
 * @category Interface
 * @package  Std\HttpMessageManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface HttpMessageManagerInterface extends EventTargetInterface
{
    const TRIGGER_BEFORE_SEND_RESPONSE = 'before.send.reponse';
    const TRIGGER_AFTER_SEND_RESPONSE = 'after.send.reponse';

    /**
     *サーバーへのリクエストを取得する
     *
     * @return ServerRequestInterface
     */
    public function getRequest() : ServerRequestInterface;

    /**
     * サーバーからのレスポンスを取得する
     *
     * @return ResponseInterface
     */
    public function getResponse() : ResponseInterface;

    /**
     * レスポンスをセットする
     *
     * @param ResponseInterface $Response
     * @return $this
     */
    public function setResponse(ResponseInterface $Response);

    /**
     * レスポンスを送信する
     *
     * @return void
     */
    public function sendResponse();

    /**
     * Method createStream
     *
     * @param string|StreamInterface $content
     * @return StreamInterface
     * @throws InvalidArgumentException if $content is neither a string or stream.
     */
    public function createStream($content) : StreamInterface;

    /**
     * Content Security Policy の script-src に自動指定する nonce 文字列を取得。
     * リクエストごとに生成
     *
     * @return string
     */
    public function getNonce() : string;
}
