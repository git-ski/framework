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
class AdminEditFieldset extends Fieldset
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
                    'action' => AdminModel::ACTION_UPDATE
                ],
                'inputSpecification' => [
                    'required' => true,
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
                            'name' => 'Laminas\\Filter\\StringTrim'
                        ]
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
                            'name' => 'Laminas\\Filter\\StringTrim'
                        ]
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
                            'name' => 'Laminas\\Filter\\StringTrim'
                        ]
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
            'email' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => false,
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

    public function checkLoginExist($login, $input) :bool
    {
        $AdminModel = $this->getObjectManager()->get(AdminModel::class);
        $Admin = $AdminModel->getOneBy([
            'login' => $login
        ]);
        if (!$Admin) {
            return true;
        }
        // あるいは、対象loginを登録しているユーザーが自分自身のであれば
        return $Admin->getAdminId() === $input['adminId'];
    }
}
