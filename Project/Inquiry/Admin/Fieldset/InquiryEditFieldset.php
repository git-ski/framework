<?php
declare(strict_types=1);

namespace Project\Inquiry\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Inquiry\Entity\Inquiry;
use Project\Inquiry\Model\InquiryModel;
use Project\Base\Helper\VocabularyHelper;

/**
 * InquiryEditFieldset
 */
class InquiryEditFieldset extends Fieldset
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
            'inquiryId' => [
                'type'      => Element\Id::class,
                'options'   => [
                    'target' => Inquiry::class,
                    'action' => InquiryModel::ACTION_UPDATE
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
            'subject' => [
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
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('subject'),
                ],
            ],
            'body' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('body'),
                ],
            ],
            'name' => [
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
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('name'),
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
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('nameSei'),
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
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('nameMei'),
                ],
            ],
            'kanaSei' => [
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
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('kanaSei'),
                ],
            ],
            'kanaMei' => [
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
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('kanaMei'),
                ],
            ],
            'rentalNo' => [
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
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('rentalNo'),
                ],
            ],
            'paypalAccount' => [
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
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('paypalAccount'),
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
                            'name' => 'NotEmpty',
                        ],
                        [
                            'name' => 'EmailAddress'
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('email'),
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
                            'name' => 'NotEmpty',
                        ],
                        [
                            'name' => 'Digits'
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
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
                            'name'    => 'InArray',
                            'options' => [
                                'haystack' => InquiryModel::getPropertyHaystack('mCustomerId')
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
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
                            'name'    => 'InArray',
                            'options' => [
                                'haystack' => InquiryModel::getPropertyHaystack('mAdminId')
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('mAdminId'),
                ],
            ],
            'processStatus' => [
                'type' => Element\Radio::class,
                'options' => [
                    'value_options' => InquiryModel::getPropertyValueOptions('processStatus')
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name'    => 'InArray',
                            'options' => [
                                'haystack' => InquiryModel::getPropertyHaystack('processStatus')
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
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
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('processDeadline'),
                ],
            ],
            'processPriority' => [
                'type' => Element\Text::class,
                'options' => [
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
                            'name' => 'Digits'
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
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
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('processComment'),
                ],
            ],
            'InquiryType' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => InquiryModel::getInquiryTypeObjects()
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
                                'haystack' => InquiryModel::getInquiryTypeObjectsHaystack()
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('InquiryType'),
                ],
            ],
            'InquiryAction' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => InquiryModel::getInquiryActionObjects()
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
                                'haystack' => InquiryModel::getInquiryActionObjectsHaystack()
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                    'placeholder' => InquiryModel::getPropertyLabel('InquiryAction'),
                ],
            ],
        ];
    }
}
