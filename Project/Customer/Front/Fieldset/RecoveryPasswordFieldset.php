<?php
declare(strict_types=1);

namespace Project\Customer\Front\Fieldset;

use Project\Customer\Front\Fieldset\CustomerPasswordFieldset;
use Project\Base\Front\Form\Element;
use Project\Customer\Model\CustomerReminderModel;

/**
 * RecoveryPasswordFieldset Fieldset
 */
class RecoveryPasswordFieldset extends CustomerPasswordFieldset
{
    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'customerId' => [
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
            ],
            'oldPassword' => [
                'type' => Element\Session::class,
                'value' => '',
            ],
            'customerPassword' => [
                'type' => Element\Password::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                        [
                            'name' => 'StringTrim'
                        ],
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                        // パスワードのバリデーター
                        // まずは、全体として許可する文字：AWS仕様
                        [
                            'name' => 'Regex',
                            'options' => [
                                'pattern' => '/^[\w\!@#\$%\^&\*\(\)\<\>\[\]\{\}\|_\+\-\=]+$/',
                                'message' => 'PASSWORD_COMMON_ERROR_01',
                            ],
                        ],
                        // そして、全体として許可する長さ：AWS仕様
                        // ※Bcryptの仕様上、72bytes以降は無視されるが、将来の新しいパスワードアルゴリズムは128サポートする見通し。
                        // 案件で調整してください。
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'min' => 8,
                                'max' => 128,
                            ]
                        ],
                        [
                            'name' => 'Callback',
                            'options' =>[
                                'callback' => [$this, 'passwordGenerationCheck'],
                                'message'  => 'PASSWORD_GENERATION_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'input-text nolanguage',
                    'placeholder' =>  CustomerReminderModel::getPropertyLabel('frontRecoveryCustomerPasswordPlaceholder'),
                ],
            ],
            'customerPasswordConfirm' => [
                'type' => Element\Password::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                        [
                            'name' => 'StringTrim'
                        ],
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                        [
                            'name' => 'Identical',
                            'options' => [
                                'token' => 'customerPassword',
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerReminderModel::getPropertyLabel('frontRecoveryCustomerPasswordConfirmPlaceholder'),
                ],
            ],
        ];
    }
}
