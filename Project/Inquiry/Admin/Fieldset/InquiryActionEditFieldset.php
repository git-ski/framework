<?php
declare(strict_types=1);

namespace Project\Inquiry\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Inquiry\Entity\InquiryAction;
use Project\Inquiry\Model\InquiryActionModel;
use Project\Base\Helper\VocabularyHelper;

/**
 * InquiryActionEditFieldset
 */
class InquiryActionEditFieldset extends Fieldset
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
            'inquiryActionId' => [
                'type'      => Element\Id::class,
                'options'   => [
                    'target' => InquiryAction::class,
                    'action' => InquiryActionModel::ACTION_UPDATE
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
            'action' => [
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
                    'class'       => 'form-control',
                    'placeholder' => InquiryActionModel::getPropertyLabel('description'),
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
                    'placeholder' => InquiryActionModel::getPropertyLabel('showPriority'),
                ],
            ],
        ];
    }
}
