<?php

declare(strict_types=1);

namespace Project\Customer\Front\Fieldset;

use Std\FormManager\Fieldset;
use Project\Base\Front\Form\Element;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Project\Customer\Entity\CustomerLoginAttemptW;
use Project\Customer\Entity\Customer as CustomerEntity;
use Project\Customer\Model\CustomerLoginAttemptWModel;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;
use Std\SessionManager\SessionManagerAwareInterface;
use Project\Customer\Model\CustomerModel;
use Project\Customer\Front\Authentication\Adapter\Customer;

/**
 * AdminUser Fieldset
 */
class CustomerLoginFieldset extends Fieldset implements
    HttpMessageManagerAwareInterface,
    ConfigManagerAwareInterface,
    SessionManagerAwareInterface,
    AuthenticationAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;
    use \Std\Authentication\AuthenticationAwareTrait;

    const DEFAULT_LOGIN_ATTEMPT_SIMULTANEOUS  = 1;

    protected $name = 'customerLogin';

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
                                'callback' => [$this, 'isExistLogin'],
                                'message' => 'FRONT_LOGIN_NOT_EXIST',
                            ]
                        ],
                        [
                            'name' => 'Callback',
                            'options' =>[
                                'callback' => [$this, 'simultaneousLoginCheck'],
                                'message' => 'FRONT_LOGIN_SIMULTANEOUS_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class' => 'input-text',
                    'tabindex' => '1',
                    'placeholder' => CustomerModel::getPropertyLabel('frontLoginPlaceholder')
                ],
            ],
        ];
    }

    public function isExistLogin($login)
    {

        $QueryBuilder = $this->getEntityManager()->createQueryBuilder();
        $QueryBuilder->select('c');
        $QueryBuilder->from(CustomerEntity::class, 'c');
        $QueryBuilder->where('c.deleteFlag = 0');
        $QueryBuilder->andWhere('c.login = :login');
        $QueryBuilder->andWhere('c.memberWithdrawDate IS NULL');
        $QueryBuilder->setParameters([
            'login'  => $login,
        ]);
        $result = $QueryBuilder->getQuery()->getResult();
        return (1 === count($result));
    }

    public function simultaneousLoginCheck($login)
    {
        $Config             = $this->getConfigManager()->getConfig('secure');
        $loginSimultaneous  = $Config['front']['login_simultaneous'] ?? null;
        if (!$loginSimultaneous) {
            return true;
        }
        $CustomerLoginAttemptWModel = $this->getObjectManager()->get(CustomerLoginAttemptWModel::class);
        $CustomerLoginAttempts      = $CustomerLoginAttemptWModel->getRepository()->findBy([
            'login'         => $login,
            'status'        => CustomerLoginAttemptWModel::getPropertyValue('status', 'CUSTOMERLOGINATTEMPTW_STATUS_SUCCESS'),
            'deleteFlag'    => 0,
        ]);
        $loginCount = 0;
        if (!empty($CustomerLoginAttempts)) {
            // 高度なsession処理はsession関数を直接アクセスするが
            // 処理終了後sessionIdを復元するために、SessionManagerを通して現sessionIDを取っておく。
            $newSessionId = $this->getSessionManager()->getId();
            foreach ($CustomerLoginAttempts as $CustomerLoginAttempt) {
                // ログイン成功レコードにsession_idを取得してチェックする。
                $sessionId = $CustomerLoginAttempt->getSessionId();
                session_abort();
                session_id($sessionId);
                session_start();
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
    }}
