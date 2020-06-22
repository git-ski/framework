<?php
declare(strict_types=1);

namespace Project\Base\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Base\Entity\VocabularyDetail;
use Project\Base\Model\VocabularyDetailModel;

/**
 * VocabularyDetailListFieldset Fieldset
 */
class VocabularyDetailFieldset extends Fieldset
{
    protected $name = 'vocabularyDetail';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'vocabularyDetailId' => [
                'type'      => Element\Hidden::class,
            ],
            'machineName' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                        [
                            'name' => 'Laminas\\Filter\\StringTrim'
                        ],
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                        [
                            'name' => 'Callback',
                            'options' => [
                                'callback' => [$this, 'checkMachineNameExist'],
                                'message' => 'VOCABULARYDETAIL_CHECK_MACHINENAME_EXIST_ERROR',
                            ],
                        ],
                        [
                            'name' => 'Regex',
                            'options' => [
                                'pattern' => '/[a-zA-Z0-9]+$/', // 半角英数記号
                                'message' => 'VOCABULARYDETAIL_MACHINENAME_ERROR',
                            ],
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
                    'placeholder' => VocabularyDetailModel::getPropertyLabel('machineName'),
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
                    'placeholder' => VocabularyDetailModel::getPropertyLabel('name'),
                ],
            ],
            'comment' => [
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
                    'placeholder' => VocabularyDetailModel::getPropertyLabel('comment'),
                ],
            ],
            'displayFlag' => [
                'type' => Element\Checkbox::class,
                'options' => [
                    'value_options' => [
                        1 => '表示'
                    ]
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                    ],
                    'validators' => [
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control disp-flag',
                    'placeholder' => VocabularyDetailModel::getPropertyLabel('displayFlag'),
                ],
            ],
        ];
    }

    public function checkMachineNameExist($machineName, $input) :bool
    {
        if (!$machineName) {
            return true;
        }
        $vocabularyDetail = $this->getObjectManager()->get(VocabularyDetailModel::class);
        $VocabularyDetail = $vocabularyDetail->getOneBy([
            'machineName' => $machineName
        ]);
        // 対象のグループコードが登録されていなければOK
        if (!$VocabularyDetail) {
            return true;
        } elseif (!array_key_exists('vocabularyDetailId', $input)) {
            return false;
        }

        // あるいは、対象のグループコードが自分自身のであればOK
        return $VocabularyDetail->getVocabularyDetailId() === (int)$input['vocabularyDetailId'];
    }
}
