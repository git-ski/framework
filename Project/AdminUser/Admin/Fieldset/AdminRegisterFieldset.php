<?php
declare(strict_types=1);

namespace Project\AdminUser\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\AdminUser\Entity\Admin;
use Project\AdminUser\Model\AdminModel;

/**
 * AdminUser Fieldset
 */
class AdminRegisterFieldset extends Fieldset
{
    protected $name = 'admin';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'adminId' => [
                'type'      => Element\Id::class,
                'options'   => [
                    'target' => Admin::class,
                    'action' => AdminModel::ACTION_CREATE
                ],
            ],
            'login' => [
                'type' => Element\Text::class,
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
                            'name'    => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'max' => 32
                            ]
                        ],
                        [
                            'name' => 'Callback',
                            'options' =>[
                                'callback' => [$this, 'checkLoginExist'],
                                'message' => 'ADMINUSER_CHECK_LOGIN_EXIST_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => AdminModel::getPropertyLabel('login'),
                ],
            ],
            'adminName' => [
                'type' => Element\Text::class,
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
                            'name'    => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'max' => 32
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => AdminModel::getPropertyLabel('adminName'),
                ],
            ],
            'adminKana' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                        [
                            'name' => 'StringTrim'
                        ],
                    ],
                    'validators' => [
                        [
                            'name'    => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'max' => 32
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => AdminModel::getPropertyLabel('adminKana'),
                ],
            ],
            'adminPassword' => [
                'type' => Element\Password::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                        [
                            'name' => 'StringTrim'
                        ],
                    ],
                    'validators' => [
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
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => AdminModel::getPropertyLabel('adminPassword'),
                ],
            ],
            'adminPasswordConfirm' => [
                'type' => Element\Password::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => false,
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
                                'token' => 'adminPassword',
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => AdminModel::getPropertyLabel('adminPasswordConfirm'),
                ],
            ],
            'email' => [
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
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => AdminModel::getPropertyLabel('email'),
                ],
            ],
            'sendmailFlag' => [
                'type' => Element\Checkbox::class,
                'options' => [
                    'value_options' => AdminModel::getPropertyValueOptions('sendmailFlag')
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                    ],
                    'validators' => [
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control disp-flag',
                    'placeholder' => AdminModel::getPropertyLabel('sendmailFlag'),
                ],
            ],
        ];
    }


    public function checkLoginExist($login) :bool
    {
        $AdminModel = $this->getObjectManager()->get(AdminModel::class);
        $Admin = $AdminModel->getOneBy([
            'login' => $login
        ]);
        return !$Admin;
    }
}
