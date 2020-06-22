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
 * VocabularyHeaderEditFieldset
 */
class VocabularyHeaderEditFieldset extends Fieldset
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
                    'action' => VocabularyHeaderModel::ACTION_UPDATE
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
            'machineName' => [
                'type' => Element\Span::class,
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
                    'class'       => '',
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
            'vocabularyDetail' => [
                'type' => Element\Collection::class,
                'options' => [
                    'count' => 1,
                    'allow_add' => true,
                    'allow_remove' => true,
                    'template_placeholder' => '__index__',
                    'target_element' => [
                        'type' => VocabularyDetailFieldset::class,
                    ]
                ],
            ],
        ];
    }
}
