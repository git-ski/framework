<?php
declare(strict_types=1);

namespace Project\AdminUser\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\AdminUser\Model\AdminModel;

/**
 * AdminUser Fieldset
 */
class AdminListFieldset extends Fieldset
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
            'login' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                        [
                            'name' => 'Laminas\\Filter\\StringTrim'
                        ],
                    ],
                    'validators' => [
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                    'placeholder' => AdminModel::getPropertyLabel('login'),
                ],
            ],
            'adminName' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                        [
                            'name' => 'Laminas\\Filter\\StringTrim'
                        ],
                    ],
                    'validators' => [
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
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
                        ],
                    ],
                    'validators' => [
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                    'placeholder' => AdminModel::getPropertyLabel('adminKana'),
                ],
            ],
            'tempPasswordFlag' => [
                'type' => Element\Checkbox::class,
                'options' => [
                    'value_options' => AdminModel::getPropertyValueOptions('tempPasswordFlag')
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name'    => 'Explode',
                            'options' => [
                                'validator' =>  [
                                    'name' => 'InArray',
                                    'options' => [
                                        'haystack' => AdminModel::getPropertyHaystack('tempPasswordFlag')
                                    ]
                                ]
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                    'placeholder' => AdminModel::getPropertyLabel('tempPasswordFlag'),
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
                    'class'       => 'form-control',
                    'placeholder' => AdminModel::getPropertyLabel('email'),
                ],
            ],
            'lastLoginDate' => [
                'type' => Element\DateTime::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                        [
                            'name'    => 'DateTimeFormatter',
                            'options' => [
                                'format' => 'Y/m/d H:i:s'
                            ]
                        ],
                    ],
                    'validators' => [
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                    'placeholder' => AdminModel::getPropertyLabel('lastLoginDate'),
                ],
            ],
            'keyword' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => false,
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
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => '検索',
                ],
            ]

        ];
    }
}
