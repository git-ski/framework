<?php
declare(strict_types=1);

namespace Project\Customer\Front\Fieldset;

use Std\FormManager\Fieldset;
use Project\Base\Front\Form\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Customer\Model\CustomerModel;

/**
 * AdminUser Fieldset
 */
class ForgotFieldset extends Fieldset
{
    protected $name = 'forgot';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'email' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                        [
                            'name' => 'Laminas\\Filter\\StringTrim'
                        ]
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty'
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontForgotEmailPlaceholder'),
                ],
            ],
            'login' => [
                'type' => Element\Text::class,
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                        [
                            'name' => 'Laminas\\Filter\\StringTrim'
                        ]
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                        [
                            'name' => 'Callback',
                            'options' =>[
                                'callback' => [$this, 'checkCustomerExist'],
                                'message' => 'CUSTOMER_CHECK_CUSTOMER_EXIST_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class' => 'input-text',
                    'placeholder' => CustomerModel::getPropertyLabel('frontLogin'),
                ],
            ],
        ];
    }

    public function checkCustomerExist($login, $input)
    {
        if($input['login'] && $input['email']){
            $criteria = [
                'login' => $input['login'],
                'email' => $input['email'],
            ];
            return $this->getObjectManager()->get(CustomerModel::class)->getCustomerBy($criteria);
        }
        return true;
    }
}
