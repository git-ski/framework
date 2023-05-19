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
 * InquiryTypeRegisterFieldset Fieldset
 */
class InquiryTypeRegisterFieldset extends Fieldset
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
                    'action' => InquiryTypeModel::ACTION_CREATE
                ],
            ],
            'type' => [
                'type' => Element\Text::class,
                'inputSpecification' => [
                    'required' => false,
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
