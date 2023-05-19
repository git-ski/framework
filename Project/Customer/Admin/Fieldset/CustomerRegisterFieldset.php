<?php
declare(strict_types=1);

namespace Project\Customer\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Customer\Entity\Customer;
use Project\Customer\Model\CustomerModel;
use Project\Customer\Admin\Controller\Customer\RegisterModel as CustomerRegisterModel;
use Project\Base\Helper\VocabularyHelper;

/**
 * CustomerRegisterFieldset Fieldset
 */
class CustomerRegisterFieldset extends Fieldset
{
    protected $name = 'customer';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        $vocalbularyHelper = $this->getObjectManager()->get(VocabularyHelper::class);
        $sexOptions = $vocalbularyHelper->getValueOptions('SEX');
        return [
            'customerId' => [
                'type'      => Element\Id::class,
                'options'   => [
                    'target' => Customer::class,
                    'action' => CustomerModel::ACTION_CREATE
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
                                'max' => 30
                            ]
                        ],
                        [
                            'name' => 'Callback',
                            'options' =>[
                                'callback' => [$this, 'checkUniqueCustomerId'],
                                'message' => 'CUSTOMER_CHECK_LOGIN_EXIST_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('login'),
                ],
            ],
            'nameSei' => [
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
                            'name'    => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'max' => 64
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('nameSei'),
                ],
            ],
            'nameMei' => [
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
                            'name'    => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'max' => 64
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('nameMei'),
                ],
            ],
            'kanaSei' => [
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
                                'max' => 64
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('kanaSei'),
                ],
            ],
            'kanaMei' => [
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
                                'max' => 64
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('kanaMei'),
                ],
            ],
            'zipCd' => [
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
                                'max' => 16
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('zipCd'),
                ],
            ],
            'address01' => [
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
                            'name'    => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'max' => 256
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('address01'),
                ],
            ],
            'address02' => [
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
                                'max' => 256
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('address02'),
                ],
            ],
            'address03' => [
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
                                'max' => 256
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('address03'),
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
                    'class'       => 'form-control nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('email'),
                ],
            ],
            'phone' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name'    => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'max' => 32
                            ]
                        ],
                        [
                            'name'  => 'Regex',
                            'options' => [
                                'pattern' => '/^([、\=\.\-\+0-9]+)$/',
                                'message' => 'CUSTOMER_PHONE_INVALIID_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('phone'),
                ],
            ],
            'birthDate' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                        [
                            'name'    => 'DateTimeFormatter',
                            'options' => [
                                'format' => 'Y-m-d'
                            ]
                        ],
                    ],
                    'validators' => [
                        [
                            'name'    => 'Date',
                            'options' => [
                                'format' => 'Y-m-d'
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control datepicker-material nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('birthDate'),
                ],
            ],
            'sexTypeId' =>[
                'type' => Element\Radio::class,
                'options'   => [
                    'value_options' => $sexOptions
                ],
                'inputSpecification' => [
                    'required' => true
                ],
                'attrs' => [
                    'class'       => 'form-control',
                ],
            ],
            'mailmagazineReceiveFlag' => [
                'type' => Element\SwitchButton::class,
                'options'   => [
                    'value_options' => CustomerModel::getPropertyValueOptions('mailmagazineReceiveFlagFront'),
                    'lever_attrs' => [
                        'class' => 'switch-col-cyan'
                    ]
                ],
                'inputSpecification' => [
                    'required' => false
                ],
                'attrs' => [
                    'class'       => 'form-control checkbox',
                ],
            ],
            'Prefecture' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => CustomerModel::getPrefectureObjects(),
                    'empty_option' => CustomerModel::getPropertyLabel('Prefecture'),
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name'    => 'InArray',
                            'options' => [
                                'haystack' => CustomerModel::getPrefectureObjectsHaystack()
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                ],
            ],
            'Country' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => CustomerModel::getCountryObjects()
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                        [
                            'name'    => 'InArray',
                            'options' => [
                                'haystack' => CustomerModel::getCountryObjectsHaystack()
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                    'placeholder' => CustomerModel::getPropertyLabel('Country'),
                ],
            ],
            'defaultLanguage' => [
                'type' => Element\Radio::class,
                'value' => CustomerModel::getPropertyValue('defaultLanguage', 'CUSTOMER_DEFAULTLANGUAGE_JA'),
                'options' => [
                    'value_options' => CustomerModel::getPropertyValueOptions('defaultLanguage'),
                ],
                'inputSpecification' => [
                    'required' => true,
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                    ],
                ],
            ],
            'sendMailToCustomer' => [
                'type' => Element\SwitchButton::class,
                'options'   => [
                    'value_options' => CustomerModel::getPropertyValueOptions('sendMailToCustomer'),
                    'lever_attrs' => [
                        'class' => 'switch-col-cyan'
                    ]
                ],
                'inputSpecification' => [
                    'required' => false
                ],
                'attrs' => [
                    'class'       => 'form-control checkbox',
                ],
            ],
        ];
    }

    // 会員IDがCustomerテーブルに存在するかどうか
    public function checkUniqueCustomerId($login, $input) :bool
    {
        $CustomerRegisterModel = $this->getObjectManager()->get(CustomerRegisterModel::class);
        $customerId = $input['customerId'] ?? null;
        $Customer = $CustomerRegisterModel->checkCustomerExist([
            'login' => $login
        ], $customerId);
        return !$Customer;
    }

    // 会員Emailが既に存在するかどうか
    public function checkUniqueEmail($email, $input) : bool
    {
        $CustomerRegisterModel = $this->getObjectManager()->get(CustomerRegisterModel::class);
        $customerId = $input['customerId'] ?? null;
        $Customer = $CustomerRegisterModel->checkCustomerExist([
            'email' => $email
        ], $customerId);
        return !$Customer;
    }
}
