<?php
declare(strict_types=1);

namespace Project\Customer\Front\Fieldset;

use Std\FormManager\Fieldset;
use Project\Base\Front\Form\Element;
use Project\Customer\Model\CustomerModel;
use Std\CryptManager\CryptManagerAwareInterface;
use Laminas\Validator\Identical;

/**
 * AdminUser Fieldset
 */
class IdentityFieldset extends Fieldset implements
    CryptManagerAwareInterface
{
    use \Std\CryptManager\CryptManagerAwareTrait;

    protected $name = 'identity';

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'customerId' => [
                'type' => Element\Id::class,
            ],
            'login' => [
                'type' => Element\Session::class,
            ],
            'loginConfirm' => [
                'type' => Element\Text::class,
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                        [
                            'name' => 'StringTrim'
                        ],
                    ],
                    'validators' => [
                        [
                            'name' => 'Identical',
                            'options' => [
                                'token' => 'login',
                                'messages' => [
                                    Identical::NOT_SAME      => "FRONT_CHECK_LOGIN_PASSWORD_ERROR",
                                    Identical::MISSING_TOKEN => 'No token was provided to match against',
                                ],
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class' => 'input-text',
                    'placeholder' => CustomerModel::getPropertyLabel('frontLoginPlaceholder')
                ],
            ],
            'customerPassword' => [
                'type' => Element\Session::class,
            ],
            'customerPasswordConfirm' => [
                'type' => Element\Password::class,
                'inputSpecification' => [
                    'required' => true,
                    'validators' => [
                        [
                            'name' => 'Callback',
                            'options' => [
                                'callback' => [$this, 'checkCustomerPassword'],
                                'message'  => 'PASSWORD_WRONG_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'input-text',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerPasswordPlaceholder'),
                    'autocomplete'=> 'on'
                ]
            ]
        ];
    }

    public function checkCustomerPassword($customerPasswordConfirm, $input)
    {
        $customerPasswordHash = $input['customerPassword'];
        return $this->getCryptManager()->getPasswordCrypt()->verify($customerPasswordConfirm, $customerPasswordHash);
    }
}
