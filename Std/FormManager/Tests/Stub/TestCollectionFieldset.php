<?php
declare(strict_types=1);

namespace Std\FormManager\Tests\Stub;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;

/**
 * AdminUser Fieldset
 */
class TestCollectionFieldset extends Fieldset
{
    protected $name = 'test';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'collection' => [
                'type' => Element\Collection::class,
                'options' => [
                    'label' => 'test',
                    'count' => 5,
                    'allow_add' => true,
                    'allow_remove' => true,
                    'template_placeholder' => '__idx__',
                    'target_element' => [
                        'test' => [
                            'type' => Element\Text::class,
                            'inputSpecification' => [
                                'required' => true,
                            ],
                            'attrs' => [
                                'class' => 'test',
                            ]
                        ]
                    ],
                ],
            ],
        ];
    }
}
