<?php
declare(strict_types=1);

namespace Project\AdminUser\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Project\AdminUser\Entity\LoginAttemptW;
use Project\AdminUser\Model\LoginAttemptWModel;
use Project\AdminUser\Admin\Authentication\AuthenticationAwareInterface;
use Std\SessionManager\SessionManagerAwareInterface;

/**
 * AdminUser Fieldset
 */
class AdminLoginFieldset extends Fieldset implements
    HttpMessageManagerAwareInterface,
    ConfigManagerAwareInterface,
    SessionManagerAwareInterface,
    AuthenticationAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;
    use \Std\Authentication\AuthenticationAwareTrait;

    const DEFAULT_LOGIN_ATTEMPT_LIMIT         = 10;
    const DEFAULT_LOGIN_ATTEMPT_LOCK          = 1800;
    const DEFAULT_LOGIN_ATTEMPT_SIMULTANEOUS  = 1;

    protected $name = 'adminLogin';

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'login' => [
                'type' => Element\Text::class,
                'inputSpecification' => [
                    'required' => true,
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                        [
                            'name' => 'Callback',
                            'options' =>[
                                'callback' => [$this, 'loginAttemptCheck'],
                                'message' => 'LOGIN_ATTEMPT_ERROR',
                            ]
                        ],
                        [
                            'name' => 'Callback',
                            'options' =>[
                                'callback' => [$this, 'simultaneousLoginCheck'],
                                'message' => 'LOGIN_SIMULTANEOUS_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class' => 'form-control',
                    'placeholder' => 'Login',
                ],
            ],
            'adminPassword' => [
                'type' => Element\Password::class,
                'inputSpecification' => [
                    'required' => true,
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Password',
                    'autocomplete'=> 'nope'
                ]
            ],
        ];
    }

    public function simultaneousLoginCheck($login)
    {
        $Config             = $this->getConfigManager()->getConfig('secure');
        $loginSimultaneous  = $Config['admin']['login_simultaneous'] ?? self::DEFAULT_LOGIN_ATTEMPT_SIMULTANEOUS;
        $LoginAttemptWModel = $this->getObjectManager()->get(LoginAttemptWModel::class);
        $LoginAttempts      = $LoginAttemptWModel->getRepository()->findBy([
            'login'         => $login,
            'status'        => LoginAttemptWModel::getPropertyValue('status', 'LOGINATTEMPTW_STATUS_SUCCESS'),
            'deleteFlag'    => 0,
        ]);
        $loginCount = 0;
        if (!empty($LoginAttempts)) {
            // 高度なsession処理はsession関数を直接アクセスするが
            // 処理終了後sessionIdを復元するために、SessionManagerを通して現sessionIDを取っておく。
            $ZfSessionManager = $this->getSessionManager()->getSessionManager();
            $newSessionId = $ZfSessionManager->getId();
            foreach ($LoginAttempts as $LoginAttempt) {
                // ログイン成功レコードにsession_idを取得してチェックする。
                $sessionId = $LoginAttempt->getSessionId();
                session_abort();
                session_id($sessionId);
                session_start();
                $this->getSessionManager()->gc();
                if ($this->getAuthentication()->hasIdentity()) {
                    $loginCount++;
                }
            }
            // ログイン状態チェック完了すれば、session状態を復元する
            session_abort();
            session_id($newSessionId);
            session_start();
            return $loginSimultaneous > $loginCount;
        }
        return true;
    }

    public function loginAttemptCheck($login)
    {
        $HttpMessageManager = $this->getHttpMessageManager();
        $Request            = $HttpMessageManager->getRequest();
        $Server             = $Request->getServerParams();
        $ip                 = $Server['HTTP_X_FORWARDED_FOR'] ?? $Server['REMOTE_ADDR'];
        $Config             = $this->getConfigManager()->getConfig('secure');
        $loginAttemptLimit  = $Config['admin']['login_attempt_limit'] ?? self::DEFAULT_LOGIN_ATTEMPT_LIMIT;
        $loginAttemptLock   = $Config['admin']['login_attempt_lock'] ?? self::DEFAULT_LOGIN_ATTEMPT_LOCK;
        $lockTime           = new \DateTime();
        $lockTime->modify('- ' . $loginAttemptLock . ' seconds');
        // 同じアカウントが重複に失敗しているのであれば。
        $QueryBuilder       = $this->prepareLoginAttemptQueryBuilder();
        $QueryBuilder->andWhere('law.login = :login');
        $QueryBuilder->groupBy('law.login');
        $QueryBuilder->setParameters([
            'login'  => $login,
            'status' => LoginAttemptWModel::getPropertyValue('status', 'LOGINATTEMPTW_STATUS_FAILTURE'),
            'cnt'    => $loginAttemptLimit,
            'lockTime' => $lockTime->format('Y-m-d H:i:s')
        ]);
        if ($result = $QueryBuilder->getQuery()->getOneOrNullResult()) {
            return false;
        }
        // あるいは、同じIPが重複に失敗しているのであれば
        $QueryBuilder       = $this->prepareLoginAttemptQueryBuilder();
        $QueryBuilder->andWhere('law.ip = :ip');
        $QueryBuilder->groupBy('law.ip');
        $QueryBuilder->setParameters([
            'ip'  => $ip,
            'status' => LoginAttemptWModel::getPropertyValue('status', 'LOGINATTEMPTW_STATUS_FAILTURE'),
            'cnt'    => $loginAttemptLimit,
            'lockTime' => $lockTime->format('Y-m-d H:i:s')
        ]);
        if ($result = $QueryBuilder->getQuery()->getOneOrNullResult()) {
            return false;
        }
        return true;
    }

    private function prepareLoginAttemptQueryBuilder()
    {
        $Config       = $this->getConfigManager()->getConfig('secure');
        $QueryBuilder = $this->getEntityManager()->createQueryBuilder();
        $QueryBuilder->select('count(law) as cnt, max(law.createDatetime) as createDatetime');
        $QueryBuilder->from(LoginAttemptW::class, 'law');
        $QueryBuilder->where('law.deleteFlag = 0');
        $QueryBuilder->andWhere('law.status = :status');
        $QueryBuilder->andWhere('law.createDatetime >= :lockTime');
        $QueryBuilder->having('cnt >= :cnt');
        return $QueryBuilder;
    }
}
