<?php
declare(strict_types=1);

namespace Project\Base\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element\Id;
use Std\ValidatorManager\ValidatorInterface;
use Project\Base\Entity\VocabularyHeader;
use Project\Base\Model\VocabularyHeaderModel;

/**
 * VocabularyHeaderDeleteFieldset
 */
class VocabularyHeaderDeleteFieldset extends Fieldset
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
                'type'      => Id::class,
                'options'   => [
                    'target' => VocabularyHeader::class,
                    'action' => VocabularyHeaderModel::ACTION_DELETE
                ],
                'inputSpecification' => [
                    'required'      => true,
                    'validators'    => [
                        [
                            'name'  => 'NotEmpty',
                        ],
                    ]
                ]
            ]
        ];
    }
}
