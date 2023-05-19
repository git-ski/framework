<?php
declare(strict_types=1);

namespace Project\Inquiry\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Inquiry\Model\InquiryActionModel;

/**
 * InquiryActionListFieldset Fieldset
 */
class InquiryActionListFieldset extends Fieldset
{
    protected $name = 'inquiryAction';

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
            'action' => [
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
                    'placeholder' => InquiryActionModel::getPropertyLabel('action'),
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
                    'placeholder' => InquiryActionModel::getPropertyLabel('description'),
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
                    'placeholder' => InquiryActionModel::getPropertyLabel('showPriority'),
                ],
            ],
        ];
    }
}
