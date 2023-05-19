<?php
/**
 * PHP version 7
 * File SessionManager.php
 *
 * @category Service
 * @package  Std
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\SessionManager;

use Framework\ObjectManager\SingletonInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Laminas\Cache\StorageFactory;
use Laminas\Session\SaveHandler\Cache;
use Laminas\Session\Config\SessionConfig;
use Laminas\Session\Storage\SessionArrayStorage;
use Laminas\Session\SessionManager as ZfSessionManager;
use Laminas\Session\Container;

/**
 * Class SessionManager
 *
 * @category Class
 * @package  Std
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class SessionManager implements
    SingletonInterface,
    ConfigManagerAwareInterface
{
    use \Framework\ObjectManager\SingletonTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    private $sessionStorage = [];
    private $SessionManager = null;

    private $secureOptions = [
        'cookie_httponly' => true,
        'cookie_secure' => true,
        'use_cookies' => true,
    ];
    /**
     * Constructor
     */
    private function __construct()
    {
    }

    /**
     * @codeCoverageIgnore
     * 外部ライブラリを使用してセッションマネージャを取得する
     * 存在しない場合、新たに作成する
     * @return ZfSessionManager
     */
    public function getSessionManager() : ZfSessionManager
    {
        if ($this->SessionManager === null) {
            $config = $this->getConfigManager()->getConfig('session');
            $storage = new \Laminas\Cache\Storage\Adapter\Memory();
            $saveHandler = new Cache($storage);
            $SessionConfig = new SessionConfig();
            $config['options'] = array_merge($config['options'], $this->secureOptions);
            $SessionConfig->setOptions($config['options']);
            $Storage = new SessionArrayStorage();
            $this->SessionManager = new ZfSessionManager($SessionConfig, $Storage, $saveHandler);
            $this->SessionManager->start();
            Container::setDefaultManager($this->SessionManager);
        }
        return $this->SessionManager;
    }

    /**
     * セッションマネージャのIDを取得する
     *
     * @return string
     */
    public function getId()
    {
        return $this->getSessionManager()->getId();
    }

    /**
     * @codeCoverageIgnore
     * 設定したセッションの生存可能期間で、gcを手動で発動させる。
     *
     * @return void
     */
    public function gc()
    {
        $config         = $this->getConfigManager()->getConfig('session');
        $options        = $config['options'];
        $maxLiftTime    = max($options['remember_me_seconds'], $options['gc_maxlifetime']);
        $SessionManager = $this->getSessionManager();
        $saveHandler    = $SessionManager->getSaveHandler();
        return $saveHandler->gc($maxLiftTime);
    }

    /**
     * keyを指定してセッションを取得する
     * 存在しない場合、新たにkeyをセッションに追加する
     *
     * @param string $namespace セッションのkey
     *
     * @return Container
     */
    public function getSession($namespace)
    {
        if (!isset($this->sessionStorage[$namespace])) {
            $this->setSession($namespace, $this->createContainer($namespace));
        }
        return $this->sessionStorage[$namespace];
    }

    /**
     * 引数に指定したkeyがセッションに存在するかチェックする
     *
     * @param string $namespace セッションのkey
     * @return boolean
     */
    public function hasSession($namespace)
    {
        return isset($this->sessionStorage[$namespace]);
    }

    /**
     * セッションに値を保存する
     *
     * @param string    $namespace key
     * @param Container $storage   値を保存したコンテナ
     *
     * @return $this
     */
    private function setSession($namespace, Container $storage)
    {
        $this->sessionStorage[$namespace] = $storage;
        return $this;
    }

    /**
     * 外部ライブラリを使用してのコンテナを作成する
     *
     * @param string $namespace key
     *
     * @return Container $container
     */
    private function createContainer($namespace)
    {
        return new Container($namespace);
    }
}
