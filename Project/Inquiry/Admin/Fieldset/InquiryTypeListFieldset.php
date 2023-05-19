<?php
declare(strict_types=1);

namespace Project\Inquiry\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Inquiry\Model\InquiryTypeModel;

/**
 * InquiryTypeListFieldset Fieldset
 */
class InquiryTypeListFieldset extends Fieldset
{
    protected $name = 'inquiryType';

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
            'type' => [
                'type' => Element\Checkbox::class,
                'options' => [
                    'value_options' => InquiryTypeModel::getPropertyValueOptions('type')
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
                                        'haystack' => InquiryTypeModel::getPropertyHaystack('type')
                                    ]
                                ]
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => InquiryTypeModel::getPropertyLabel('type'),
                ],
            ],
            'description' => [
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
                    'placeholder' => InquiryTypeModel::getPropertyLabel('description'),
                ],
            ],
            'showPriority' => [
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
                    'placeholder' => InquiryTypeModel::getPropertyLabel('showPriority'),
                ],
            ],
        ];
    }
}
