<?php
/**
 * PHP version 7
 * File AuthenticationInterface.php
 *
 * @category Authentication
 * @package  Std\Authentication
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\Authentication;

use Framework\ObjectManager\ObjectManager;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\ObjectManager\SingletonInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Storage;
use Laminas\Authentication\Adapter;
use Std\SessionManager\SessionManager;
use Std\SessionManager\SessionManagerAwareInterface;

/**
 * Interface AuthenticationInterface
 *
 * @category Authentication
 * @package  Std\Authentication
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
abstract class AbstractAuthentication extends AuthenticationService implements
    AuthenticationInterface,
    ObjectManagerAwareInterface,
    CryptManagerAwareInterface,
    SessionManagerAwareInterface,
    SingletonInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Framework\EventManager\EventTargetTrait;
    use \Framework\ObjectManager\SingletonTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;

    /**
     * Constructor
     *
     * @param Storage\StorageInterface|null $Storage Storage
     * @param Adapter\AdapterInterface|null $Adapter Adapter
     */
    public function __construct(Storage\StorageInterface $Storage = null, Adapter\AdapterInterface $Adapter = null)
    {
        $this->triggerEvent(self::TRIGGER_INIT);
        $ObjectManager  = ObjectManager::getSingleton();
        $SessionManager = $ObjectManager->get(SessionManager::class);
        if ($Storage === null) {
            $Storage = new Storage\Session(static::class, __NAMESPACE__, $SessionManager->getSessionManager());
        }
        parent::__construct($Storage, $Adapter);
    }

    /**
     * 認証を行う
     *
     * @param string $username ユーザ名
     * @param string $password パスワード
     *
     * @return void
     */
    abstract public function login($username, $password);

    /**
     * 認証IDを追加する
     *
     * @param array $exIdentity ID
     *
     * @return void
     */
    public function updateIdentity(array $exIdentity)
    {
        $identity = (array) $this->getIdentity();
        $identity = array_merge($identity, $exIdentity);
        $this->getStorage()->write($identity);
    }
}
