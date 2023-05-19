<?php
declare(strict_types=1);

namespace Project\Customer\Front\Fieldset;

use Project\Customer\Front\Fieldset\CustomerRegisterFieldset;
use Project\Base\Front\Form\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Customer\Model\CustomerModel;

/**
 * CustomerEditFieldset Fieldset
 */
class CustomerEditFieldset extends CustomerRegisterFieldset
{
    protected $name = 'customer';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        $field = parent::getDefaultFieldset();
        $field['customerId'] = [
            'type'      => Element\Id::class,
            'options'   => [
            ],
            'inputSpecification' => [
                'required'      => true,
                'validators'    => [
                    [
                        'name'  => 'NotEmpty',
                    ],
                ]
            ]
        ];
        $field['email'] = [
            'type' => Element\Text::class,
            'options' => [
            ],
            'inputSpecification' => [
                'required' => true,
                'filters' => [
                ],
                'validators' => [
                    [
                        'name' => 'EmailAddress'
                    ],
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'max' => 128
                        ]
                    ],
                    [
                        'name' => 'Callback',
                        'options' =>[
                            'callback' => [$this, 'checkUniqueEmail'],
                            'message' => 'CUSTOMER_CHECK_EMAIL_EXIST_ERROR',
                        ]
                    ],
                ]
            ],
            'attrs' => [
                'class'       => 'input-text nolanguage',
                'placeholder' =>  CustomerModel::getPropertyLabel('frontEmailPlaceholder'),
            ]
        ];
        unset($field['customerPassword'], $field['customerPasswordConfirm']);
        return $field;
    }

}
