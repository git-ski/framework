<?php
declare(strict_types=1);

namespace Project\Customer\Front\Fieldset;

use Std\FormManager\Fieldset;
use Project\Base\Front\Form\Element;
use Project\Customer\Front\Controller\Customer\WithdrawModel;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;
use Std\SessionManager\SessionManagerAwareInterface;
use Project\Customer\Front\Authentication\Adapter\Customer;
use Project\Customer\Entity\Customer as CustomerEntity;

/**
 * CustomerWithdraw Fieldset
 */
class CustomerWithdrawFieldset extends Fieldset implements
    HttpMessageManagerAwareInterface,
    ConfigManagerAwareInterface,
    SessionManagerAwareInterface,
    AuthenticationAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;
    use \Std\Authentication\AuthenticationAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;

    protected $name = 'customer';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'customerId' => [
                'type' => Element\Session::class
            ],
            'withdrawReason' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => WithdrawModel::getPropertyValueOptions('withdrawReason'),
                    'empty_option' => WithdrawModel::getPropertyLabel('frontCustomerWithdrawReasonEmptyOption'),
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                    ]
                ],
                'attrs' => [
                    'class' => 'select-box-item'
                ],
            ],
            'withdrawNote' => [
                'type' => Element\Textarea::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                    ],
                    'validators' => [
                    ]
                ],
                'attrs' => [
                    'class' => 'textarea',
                    'placeholder' => WithdrawModel::getPropertyLabel('frontCustomerWithdrawNotePlaceholder'),
                    'rows' => 4
                ],
            ],
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
                                'callback' => [$this, 'checkAuthInfo'],
                                'message' => 'WITHDRAW_AUTH_ERROR',
                            ]
                        ]
                    ]
                ],
                'attrs' => [
                    'class' => 'input-text',
                    'placeholder' => WithdrawModel::getPropertyLabel('frontLoginPlaceholder'),
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
                    'placeholder' => WithdrawModel::getPropertyLabel('frontCustomerPasswordPlaceholder'),
                    'autocomplete'=> 'off'
                ]
            ],
        ];
    }

    public function checkAuthInfo($login, $input)
    {
        $data = $this->form->getData();

        if (empty($data['customer']['login']) || empty($data['customer']['customerPassword'])) {
            return false;
        }

        $authAdapter = $this->getAuthentication();
        $identity = $authAdapter->getIdentity();
        $CustomerRepository = $this->getEntityManager()->getRepository(CustomerEntity::class);
        $Customer = $CustomerRepository->findOneBy([
            'login'                 => $data['customer']['login'],
            'deleteFlag'            => 0,
            'memberWithdrawDate'    => null,
            'customerId'            => $identity['customerId'],
        ]);
        $Adapter = $this->getObjectManager()->create(Customer::class);
        if ($Customer && $Adapter->getCrypt()->verify($data['customer']['customerPassword'], $Customer->getCustomerPassword())) {
            return true;
        }

        return false;
    }
}
