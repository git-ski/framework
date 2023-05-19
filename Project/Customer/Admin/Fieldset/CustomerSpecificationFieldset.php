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
use Project\Base\Entity\Prefecture;
use Project\Base\Entity\Country;

/**
 * CustomerRegisterFieldset Fieldset
 */
class CustomerSpecificationFieldset extends Fieldset
{
    protected $name = 'customer';

    public function getHeader()
    {
        return [
            'customerId'            => '顧客ID',
            'login'                 => 'ログインID',
            'nameSei'               => '名前(姓)',
            'nameMei'               => '名前(名)',
            'kanaSei'               => 'カナ(姓)',
            'kanaMei'               => 'カナ(名)',
            'zipCd'                 => '郵便番号',
            'address01'             => '市区町村',
            'address02'             => '番地',
            'address03'             => '建物名',
            'email'                 => 'PCメールアドレス',
            'phone'                 => '電話番号',
            'birthDate'             => '生年月日',
            'sexTypeId'             => '性別',
            'mailmagazineReceiveFlag'=> 'メルマガ受信フラグ',
            'Prefecture'            => '都道府県',
            'Country'               => '国',
        ];
    }

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'customerId' => [
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                        [
                            'name' => 'Digits'
                        ],
                    ],
                    'validators' => [
                        [
                            'name'    => 'Digits',
                        ],
                    ]
                ],            ],
            'login' => [
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
            ],
            'nameSei' => [
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
            ],
            'nameMei' => [
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
            ],
            'kanaSei' => [
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
            ],
            'kanaMei' => [
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
            ],
            'zipCd' => [
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
            ],
            'address01' => [
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
            ],
            'address02' => [
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
            ],
            'address03' => [
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
            ],
            'email' => [
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name' => 'EmailAddress'
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
            ],
            'phone' => [
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
                                'pattern' => '/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.0-9]*$/',
                                'message' => 'CUSTOMER_PHONE_INVALIID_ERROR',
                            ]
                        ],
                    ]
                ],
            ],
            'birthDate' => [
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
            ],
            'sexTypeId' =>[
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                        [
                            'name' => 'Callback',
                            'options' => [
                                'callback' => [$this, 'filterSexTypeId']
                            ]
                        ],
                    ],
                    'validators' => [
                        [
                            'name'    => 'InArray',
                            'options' => [
                                'haystack' => $this->getSexTypeStack()
                            ],
                        ],
                    ]
                ],
            ],
            'mailmagazineReceiveFlag' => [
                'inputSpecification' => [
                    'required' => false
                ],
            ],
            'Prefecture' => [
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                        [
                            'name' => 'Callback',
                            'options' => [
                                'callback' => [$this, 'filterPrefecture']
                            ]
                        ],
                    ],
                    'validators' => [
                        [
                            'name'    => 'InArray',
                            'options' => [
                                'haystack' => $this->getPrefectureStack()
                            ],
                        ],
                    ]
                ],
            ],
            'Country' => [
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                        [
                            'name' => 'Callback',
                            'options' => [
                                'callback' => [$this, 'filterCountry']
                            ]
                        ],
                    ],
                    'validators' => [
                        [
                            'name'    => 'InArray',
                            'options' => [
                                'haystack' => $this->getCountryStack()
                            ],
                        ],
                    ]
                ],
            ],
        ];
    }

    public function filterSexTypeId($sexTypeId)
    {
        $vocalbularyHelper = $this->getObjectManager()->get(VocabularyHelper::class);
        $sexOptions = $vocalbularyHelper->getValueOptions('SEX');
        if (is_numeric($sexTypeId)) {
            return $sexOptions[$sexTypeId] ?? 'invalid';
        } else {
            return array_search($sexTypeId, $sexOptions) ?? 'invalid';
        }
    }

    private function getSexTypeStack()
    {
        $vocalbularyHelper = $this->getObjectManager()->get(VocabularyHelper::class);
        $sexOptions = $vocalbularyHelper->getValueOptions('SEX');
        return array_keys($sexOptions) + array_values($sexOptions);
    }

    public function filterPrefecture($Prefecture)
    {
        if ($Prefecture instanceof Prefecture) {
            return $Prefecture->getPrefectureName();
        } else {
            foreach (CustomerModel::getPrefectureObjects() as $id => $Name) {
                if ($Name === $Prefecture) {
                    return $id;
                }
            }
        }
        return null;
    }

    private function getPrefectureStack()
    {
        $PrefectureObjects = CustomerModel::getPrefectureObjects();
        return array_keys($PrefectureObjects) + array_values($PrefectureObjects);
    }

    public function filterCountry($Country)
    {
        if ($Country instanceof Country) {
            return $Country->getCountryName();
        } else {
            foreach (CustomerModel::getCountryObjects() as $id => $Name) {
                if ($Name === $Country) {
                    return $id;
                }
            }
        }
        return null;
    }

    private function getCountryStack()
    {
        $CountryObjects = CustomerModel::getCountryObjects();
        return array_keys($CountryObjects) + array_values($CountryObjects);
    }

    public function checkUniqueCustomerId($login, $input) :bool
    {
        $CustomerRegisterModel = $this->getObjectManager()->get(CustomerRegisterModel::class);
        $customerId = $input['customerId'] ?? null;
        $Customer = $CustomerRegisterModel->checkCustomerExist([
            'login' => $login
        ], $customerId);
        return !$Customer;
    }

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
