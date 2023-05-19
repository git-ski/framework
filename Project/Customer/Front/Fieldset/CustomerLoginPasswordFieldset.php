<?php
declare(strict_types=1);

namespace Project\Customer\Front\Fieldset;

use Std\FormManager\Fieldset;
use Project\Base\Front\Form\Element;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Project\Customer\Entity\CustomerLoginAttemptW;
use Project\Customer\Model\CustomerLoginAttemptWModel;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;
use Std\SessionManager\SessionManagerAwareInterface;
use Project\Customer\Model\CustomerModel;
use Project\Customer\Front\Authentication\Adapter\Customer;
use Std\SessionManager\FlashMessage;
use Project\Customer\Front\Controller\Login\LoginController;

/**
 * AdminUser Fieldset
 */
class CustomerLoginPasswordFieldset extends Fieldset implements
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

    protected $name = 'customerLoginPassword';

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        $Session = $this->getSessionManager()->getSession(LoginController::LOGIN);
        return [
            'login' => [
                'type' => Element\Hidden::class,
                'value' => $Session->login,
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
                                'message' => 'FRONT_LOGIN_ATTEMPT_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class' => 'input-text',
                    'placeholder' => CustomerModel::getPropertyLabel('frontLoginPlaceholder')
                ],
            ],
            'customerPassword' => [
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
                    'class'       => 'input-text',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerPasswordPlaceholder'),
                    'autocomplete'=> 'on'
                ]
            ],
            'remberMe' => [
                'type' => Element\Checkbox::class,
                'options' => [
                    'value_options' => [ 'ログインしたままにする' ],
                ],
                'inputSpecification' => [
                    'required' => false,
                ],
                'attrs' => [
                    'class'       => 'form-control',
                ],
            ]
        ];
    }

    public function loginAttemptCheck($login)
    {
        $HttpMessageManager = $this->getHttpMessageManager();
        $Request            = $HttpMessageManager->getRequest();
        $Server             = $Request->getServerParams();
        $ip                 = $Server['HTTP_X_FORWARDED_FOR'] ?? $Server['REMOTE_ADDR'];
        $Config             = $this->getConfigManager()->getConfig('secure');
        $loginAttemptLimit  = $Config['front']['login_attempt_limit'] ?? self::DEFAULT_LOGIN_ATTEMPT_LIMIT;
        $loginAttemptLock   = $Config['front']['login_attempt_lock'] ?? self::DEFAULT_LOGIN_ATTEMPT_LOCK;
        $lockTime           = new \DateTime();
        $lockTime->modify('- ' . $loginAttemptLock . ' seconds');
        // 同じアカウントが重複に失敗しているのであれば。
        $QueryBuilder       = $this->prepareLoginAttemptQueryBuilder();
        $QueryBuilder->andWhere('law.login = :login');
        $QueryBuilder->groupBy('law.login');
        $QueryBuilder->setParameters([
            'login'  => $login,
            'status' => CustomerLoginAttemptWModel::getPropertyValue('status', 'CUSTOMERLOGINATTEMPTW_STATUS_FAILTURE'),
            'cnt'    => $loginAttemptLimit,
            'lockTime' => $lockTime->format('Y-m-d H:i:s')
        ]);
        if ($result = $QueryBuilder->getQuery()->getOneOrNullResult()) {
            return false;
        }
        // あるいは、同じIPが重複に失敗しているのであれば // 20181001 IPアドレスでのロック判断を外す　フロントのみ
        // $QueryBuilder       = $this->prepareLoginAttemptQueryBuilder();
        // $QueryBuilder->andWhere('law.ip = :ip');
        // $QueryBuilder->groupBy('law.ip');
        // $QueryBuilder->setParameters([
        //     'ip'  => $ip,
        //     'status' => CustomerLoginAttemptWModel::getPropertyValue('status', 'CUSTOMERLOGINATTEMPTW_STATUS_FAILTURE'),
        //     'cnt'    => $loginAttemptLimit,
        //     'lockTime' => $lockTime->format('Y-m-d H:i:s')
        // ]);
        // if ($result = $QueryBuilder->getQuery()->getOneOrNullResult()) {
        //     return false;
        // }
        return true;
    }

    private function prepareLoginAttemptQueryBuilder()
    {
        $QueryBuilder = $this->getEntityManager()->createQueryBuilder();
        $QueryBuilder->select('count(law) as cnt');
        $QueryBuilder->from(CustomerLoginAttemptW::class, 'law');
        $QueryBuilder->where('law.deleteFlag = 0');
        $QueryBuilder->andWhere('law.status = :status');
        $QueryBuilder->andWhere('law.createDatetime >= :lockTime');
        $QueryBuilder->having('cnt >= :cnt');
        return $QueryBuilder;
    }

    public function checkLogin($login, $input)
    {
        if(!empty($login) && !empty($input['customerPassword'])){
            $CustomerModel = $this->getObjectManager()->get(Customer::class);
            $where = array(
                    'login'         => $login,
                    'deleteFlag'    => 0,
                );
            $Customer = $this->getObjectManager()->get(CustomerModel::class)->getOneBy($where);
            if($Customer){
                $customerPassword = $CustomerModel->getCrypt()->verify($input['customerPassword'],$Customer->getCustomerPassword());
               return $customerPassword;
            }
            return false;
        }
        return true;
    }
}
