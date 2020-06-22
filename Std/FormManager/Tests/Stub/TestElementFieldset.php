<?php
declare(strict_types=1);

namespace Std\FormManager\Tests\Stub;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;

/**
 * AdminUser Fieldset
 */
class TestElementFieldset extends Fieldset
{
    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'text' => [
                'type' => Element\Text::class,
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'checkbox' => [
                'type' => Element\Checkbox::class,
                'options' => [
                    'value_options' => [
                        1 => 't', 2 => 'e', 3 => 's', 4 => 't'
                    ]
                ],
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'inline_checkbox' => [
                'type' => Element\InLineCheckbox::class,
                'options' => [
                    'value_options' => [
                        1 => 't', 2 => 'e', 3 => 's', 4 => 't'
                    ]
                ],
                'value' => [2],
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'date' => [
                'type' => Element\Date::class,
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'datetime' => [
                'type' => Element\DateTime::class,
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'hidden' => [
                'type' => Element\hidden::class,
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'radio' => [
                'type' => Element\Radio::class,
                'options' => [
                    'value_options' => [
                        1 => 't', 2 => 'e', 3 => 's', 4 => 't'
                    ]
                ],
                'value' => 1,
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'inline_radio' => [
                'type' => Element\InLineRadio::class,
                'options' => [
                    'value_options' => [
                        1 => 't', 2 => 'e', 3 => 's', 4 => 't'
                    ]
                ],
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'reset' => [
                'type' => Element\Reset::class,
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'select' => [
                'type' => Element\Select::class,
                'options' => [
                    'empty_option' => '-- test --',
                    'value_options' => [
                        1 => 't', 2 => 'e', 3 => 's', 4 => 't'
                    ]
                ],
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'span' => [
                'type' => Element\Span::class,
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'submit' => [
                'type' => Element\Submit::class,
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'textarea' => [
                'type' => Element\Textarea::class,
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'time' => [
                'type' => Element\Time::class,
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
            'password' => [
                'type' => Element\Password::class,
                'inputSpecification' => [
                    'required' => true,
                ],
            ],
        ];
    }
}
