<?php
declare(strict_types=1);

namespace Project\Base\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Base\Entity\VocabularyHeader;
use Project\Base\Model\VocabularyHeaderModel;
use Project\Base\Helper\VocabularyHelper;

/**
 * VocabularyHeaderRegisterFieldset Fieldset
 */
class VocabularyHeaderRegisterFieldset extends Fieldset
{
    protected $name = 'vocabularyHeader';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'vocabularyHeaderId' => [
                'type'      => Element\Id::class,
                'options'   => [
                    'target' => VocabularyHeader::class,
                    'action' => VocabularyHeaderModel::ACTION_CREATE
                ],
            ],
            'machineName' => [
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
                    'class'       => 'form-control nolanguage',
                    'placeholder' => VocabularyHeaderModel::getPropertyLabel('machineName'),
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
                    'class'       => 'form-control',
                    'placeholder' => VocabularyHeaderModel::getPropertyLabel('name'),
                ],
            ],
            'comment' => [
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
                    'placeholder' => VocabularyHeaderModel::getPropertyLabel('comment'),
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
                    'class'       => 'form-control nolanguage',
                    'placeholder' => VocabularyHeaderModel::getPropertyLabel('showPriority'),
                ],
            ],
        ];
    }
}
