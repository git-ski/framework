<?php
declare(strict_types=1);

namespace Project\Customer\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Customer\Model\CustomerModel;

/**
 * CustomerListFieldset Fieldset
 */
class CustomerListFieldset extends Fieldset
{
    protected $name = 'customer';

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
                    'placeholder' => CustomerModel::getPropertyLabel('keyword'),
                ],
            ],
            'exportCsv' => [
                'type' => Element\Submit::class,
                'value' => '検索結果CSVダウンロード',
            ],
        ];
    }
}
