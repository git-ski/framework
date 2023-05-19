<?php
declare(strict_types=1);

namespace Project\Customer\Front\Fieldset;

use Std\FormManager\Fieldset;
use Project\Base\Front\Form\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Customer\Model\CustomerModel;
use Project\Customer\Front\Controller\Customer\RegisterModel as CustomerRegisterModel;
use Project\Customer\Front\Fieldset\CustomerProvisionalFieldset;
use Project\Base\Model\CountryModel;
use DateTime;
use Project\Base\Helper\VocabularyHelper;

/**
 * AdminUser Fieldset
 */
class CustomerRegisterFieldset extends CustomerProvisionalFieldset
{
    protected $name = 'customer';
    protected $birthDateYearOptions;

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        $prefectureRequired = $this->getPrefectureRequired();
        $vocalbularyHelper = $this->getObjectManager()->get(VocabularyHelper::class);

        return [
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
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontLoginPlaceholder'),
                ],
            ],
            'customerTemporaryLId' => [
                'type'      => Element\Id::class,
                'options'   => [
                ],
            ],
            'customerId' => [
                'type'      => Element\Id::class,
                'options'   => [
                ],
            ],
            'email' => [
                'type' => Element\Span::class,
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
                    'placeholder' => CustomerModel::getPropertyLabel('frontEmailPlaceholder'),
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
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerNameSeiPlaceholder'),
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
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerNameMeiPlaceholder'),
                ],
            ],
            'kanaSei' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => $prefectureRequired,
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
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerKanaSeiPlaceholder'),
                ],
            ],
            'kanaMei' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => $prefectureRequired,
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
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerKanaMeiPlaceholder'),
                ],
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
                                'max' => 256,
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerPasswordPlaceholder'),
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
                            'name' => 'Identical',
                            'options' => [
                                'token' => 'customerPassword',
                            ],
                        ],
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'min' => 8,
                                'max' => 256,
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerPasswordConfirmPlaceholder'),
                ],
            ],
            'tempPasswordFlag' => [
                'type' => Element\Session::class,
                'inputSpecification' => [
                    'required' => false,
                ],
                'value' => 0,
            ],
            'zipCd' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => $prefectureRequired,
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
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerZipCdPlaceholder'),
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
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerAddress01Placeholder'),
                ],
            ],
            'address02' => [
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
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerAddress02Placeholder'),
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
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerAddress03Placeholder'),
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
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerPhonePlaceholder'),
                ],
            ],
            'birthDateYear' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => $this->getBirthDateYearOptions(),
                    'empty_option' => CustomerModel::getPropertyLabel('frontBirthDateYear'),
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
                                'haystack' => $this->getBirthDateYearOptions()
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'select-box-item nolanguage',
                ],
            ],
            'birthDateMonth' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => $this->getBirthDateMonthOptions(),
                    'empty_option' => CustomerModel::getPropertyLabel('frontBirthDateMonth'),
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
                                'haystack' => $this->getBirthDateMonthOptions(true)
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'select-box-item nolanguage',
                ],
            ],
            'birthDateDay' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => $this->getBirthDateDayOptions(),
                    'empty_option' => CustomerModel::getPropertyLabel('frontBirthDateDay'),
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
                                'haystack' => $this->getBirthDateDayOptions(true)
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'select-box-item nolanguage',
                ],
            ],
            'birthDateCheck' => [
                'type' => Element\Text::class,
                'value' => 1,
                'inputSpecification' => [
                    'required' => false,
                    'validators' => [
                        // [
                        //     'name' => 'Callback',
                        //     'options' =>[
                        //         'callback' => [$this, 'checkBirthDate'],
                        //         'message' => 'CUSTOMER_BIRTHDATE_INVALIID_ERROR',
                        //     ]
                        // ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'nolanguage',
                ],
            ],
            'sexTypeId' =>[
                'type' => Element\InLineRadio::class,
                'options'   => [
                    'value_options' => [
                        1 => '男性', 2 => '女性'
                    ]
                ],
                'inputSpecification' => [
                    'required' => true
                ],
                'attrs' => [
                    'class'       => 'form-control',
                ],
            ],
            'mailmagazineReceiveFlag' => [
                'type' => Element\Checkbox::class,
                'options'   => [
                    'value_options' => CustomerModel::getPropertyValueOptions('mailmagazineReceiveFlagFront')
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
                    'empty_option' => '-',
                ],
                'inputSpecification' => [
                    'required' => $prefectureRequired,
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
                    'class'       => 'select-box-item nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerPrefecturePlaceholder'),
                ],
            ],
            'Country' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => CustomerModel::getCountryObjects(),
                    'empty_option' => '-',
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
                    'class'       => 'select-box-item nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerCountryPlaceholder'),
                ],
            ],
        ];
    }
    public function getBirthDateYearOptions(): array
    {
        if (empty($this->birthDateYearOptions)) {
            $this->birthDateYearOptions = [];
            $now = new DateTime();
            $yearOld = 1904;
            $year = (int) $now->format('Y');
            while ($year > $yearOld) {
                $this->birthDateYearOptions[$year] = $year;
                $year--;
            }
        }
        return $this->birthDateYearOptions;
    }
    public function getBirthDateMonthOptions($haystack = false): array
    {
        $options = [];
        for ($i = 1; $i <= 12; $i++) {
            if (!$haystack) {
                if ($i < 10) {
                    $options[$i] = '0' . $i;
                } else {
                    $options[$i] = $i;
                }
            } else {
                $options[] = $i;
            }
        }
        return $options;
    }
    public function getBirthDateDayOptions($haystack = false): array
    {
        $options = [];
        for ($i = 1; $i <= 31; $i++) {
            if (!$haystack) {
                if ($i < 10) {
                    $options[$i] = '0' . $i;
                } else {
                    $options[$i] = $i;
                }
            } else {
                $options[] = $i;
            }
        }
        return $options;
    }

    public function checkBirthDate($val, $input): bool
    {
        if (!checkdate((int)$input['birthDateMonth'], (int)$input['birthDateDay'], (int)$input['birthDateYear'])) {
            return false;
        }
        if (mktime(0, 0, 0, (int)$input['birthDateMonth'], (int)$input['birthDateDay'], (int)$input['birthDateYear']) >= time()) {
            return false;
        }
        return true;
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

    protected function getPrefectureRequired(): bool
    {
        return false;
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
