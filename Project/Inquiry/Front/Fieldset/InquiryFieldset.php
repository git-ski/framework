<?php
declare(strict_types=1);

namespace Project\Inquiry\Front\Fieldset;

use Std\FormManager\Fieldset;
use Std\ValidatorManager\ValidatorInterface;
use Project\Inquiry\Model\InquiryModel;
use Project\Base\Front\Form\Element;

/**
 * Inquiry Fieldset
 */
class InquiryFieldset extends Fieldset
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
                ],
            ],
            'body' => [
                'type' => Element\Textarea::class,
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
                            'name'    => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'max' => 2000
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'textarea',
                    'placeholder' => InquiryModel::getPropertyLabel('frontBodyPlaceholder'),
                    'rows'        => 4
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
                    'class'       => 'input-text',
                    'placeholder' => InquiryModel::getPropertyLabel('frontNamePlaceholder'),
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
                    'class'       => 'input-text',
                    'placeholder' => InquiryModel::getPropertyLabel('frontRentalNoPlaceholder'),
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
                    'class'       => 'input-text',
                    'placeholder' => InquiryModel::getPropertyLabel('frontEmailPlaceholder'),
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
                    'class'       => 'input-text',
                    'placeholder' => InquiryModel::getPropertyLabel('frontPhonePlaceholder'),
                ],
            ],
            'InquiryType' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => InquiryModel::getInquiryTypeObjects(),
                    'empty_option' => InquiryModel::getPropertyLabel('frontInquiryTypeEmptyOption'),
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
                    'class' => 'select-box-item'
                ],
            ],
            'InquiryAction' => [
                'type' => Element\Select::class,
                'options' => [
                    'value_options' => InquiryModel::getInquiryActionObjects(),
                    'empty_option' => InquiryModel::getPropertyLabel('frontInquiryActionEmptyOption'),
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
                    'class' => 'select-box-item'
                ],
            ],
        ];
    }
}
