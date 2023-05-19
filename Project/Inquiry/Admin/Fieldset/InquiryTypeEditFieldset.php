<?php
declare(strict_types=1);

namespace Project\Inquiry\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Inquiry\Entity\InquiryType;
use Project\Inquiry\Model\InquiryTypeModel;
use Project\Base\Helper\VocabularyHelper;

/**
 * InquiryTypeEditFieldset
 */
class InquiryTypeEditFieldset extends Fieldset
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
            'inquiryTypeId' => [
                'type'      => Element\Id::class,
                'options'   => [
                    'target' => InquiryType::class,
                    'action' => InquiryTypeModel::ACTION_UPDATE
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
            'type' => [
                'type' => Element\Radio::class,
                'options' => [
                    'value_options' => InquiryTypeModel::getPropertyValueOptions('type')
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name'    => 'InArray',
                            'options' => [
                                'haystack' => InquiryTypeModel::getPropertyHaystack('type')
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
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
                    'class'       => 'form-control',
                    'placeholder' => InquiryTypeModel::getPropertyLabel('description'),
                ],
            ],
            'showPriority' => [
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
                    'placeholder' => InquiryTypeModel::getPropertyLabel('showPriority'),
                ],
            ],
        ];
    }
}
