<?php
declare(strict_types=1);

namespace Project\Inquiry\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Inquiry\Model\InquiryModel;

/**
 * InquiryListFieldset Fieldset
 */
class InquiryListFieldset extends Fieldset
{
    protected $name = 'inquiry';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'keyword' => [
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
                    'class'       => 'form-control nolanguage',
                    'placeholder' => 'Keyword',
                ],
            ],
            'subject' => [
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
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('subject'),
                ],
            ],
            'body' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                    ],
                    'validators' => [
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('body'),
                ],
            ],
            'name' => [
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
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('name'),
                ],
            ],
            'nameSei' => [
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
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('nameSei'),
                ],
            ],
            'nameMei' => [
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
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('nameMei'),
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
                            'name' => 'Laminas\\Filter\\StringTrim'
                        ],
                    ],
                    'validators' => [
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('kanaSei'),
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
                            'name' => 'Laminas\\Filter\\StringTrim'
                        ],
                    ],
                    'validators' => [
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('kanaMei'),
                ],
            ],
            'rentalNo' => [
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
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('rentalNo'),
                ],
            ],
            'paypalAccount' => [
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
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('paypalAccount'),
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
                    'placeholder' => InquiryModel::getPropertyLabel('email'),
                ],
            ],
            'phone' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                    ],
                    'validators' => [
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('phone'),
                ],
            ],
            'mCustomerId' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => InquiryModel::getPropertyValueOptions('mCustomerId')
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
                                        'haystack' => InquiryModel::getPropertyHaystack('mCustomerId')
                                    ]
                                ]
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('mCustomerId'),
                ],
            ],
            'mAdminId' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => InquiryModel::getPropertyValueOptions('mAdminId')
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
                                        'haystack' => InquiryModel::getPropertyHaystack('mAdminId')
                                    ]
                                ]
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('mAdminId'),
                ],
            ],
            'processStatus' => [
                'type' => Element\Checkbox::class,
                'options' => [
                    'value_options' => InquiryModel::getPropertyValueOptions('processStatus')
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
                                        'haystack' => InquiryModel::getPropertyHaystack('processStatus')
                                    ]
                                ]
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('processStatus'),
                ],
            ],
            'processDeadline' => [
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
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('processDeadline'),
                ],
            ],
            'processPriority' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                    ],
                    'validators' => [
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('processPriority'),
                ],
            ],
            'processComment' => [
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
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('processComment'),
                ],
            ],
            'InquiryType' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => InquiryModel::getInquiryTypeObjects('InquiryType')
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
                                        'haystack' => InquiryModel::getInquiryTypeObjectsHaystack('InquiryType')
                                    ]
                                ]
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('InquiryType'),
                ],
            ],
            'InquiryAction' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => InquiryModel::getInquiryActionObjects('InquiryAction')
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
                                        'haystack' => InquiryModel::getInquiryActionObjectsHaystack('InquiryAction')
                                    ]
                                ]
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryModel::getPropertyLabel('InquiryAction'),
                ],
            ],
        ];
    }
}
