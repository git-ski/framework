<?php
declare(strict_types=1);

namespace Project\Permission\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Project\Permission\Model\RoleModel;

/**
 * AdminUser Fieldset
 */
class RoleListFieldset extends Fieldset
{
    protected $name = 'role';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        $RoleModel = $this->getObjectManager()->get(RoleModel::class);
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
                    'class'       => 'form-control',
                    'placeholder' => RoleModel::getPropertyLabel('keyword'),
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
                    'class'       => 'form-control',
                    'placeholder' => 'show_priority',
                ],
            ],
        ];
    }
}
