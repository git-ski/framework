<?php
declare(strict_types=1);

namespace Std\FormManager\Tests\Stub;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;

/**
 * AdminUser Fieldset
 */
class TestFieldset extends Fieldset
{
    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'test' => [
                'type' => Element\Text::class,
                'inputSpecification' => [
                    'required' => true,
                ],
                'attrs' => [
                    'class' => 'test',
                ]
            ],
        ];
    }
}
