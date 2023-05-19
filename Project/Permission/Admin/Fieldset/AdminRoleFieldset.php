<?php
declare(strict_types=1);

namespace Project\Permission\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Project\Permission\Model\RoleModel;

/**
 * AdminUser Fieldset
 */
class AdminRoleFieldset extends Fieldset
{
    protected $name = 'role';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        $RoleList = $this->getObjectManager()->get(RoleModel::class)->getList();
        $valueOptions = $haystack = [];
        foreach ($RoleList as $Role) {
            $haystack[] = $Role->getRoleId();
            $valueOptions[$Role->getRoleId()] = $Role->getRole();
        }
        $fieldset  = [
            'roles' => [
                'type' => Element\Checkbox::class,
                'options' => [
                    'value_options' => $valueOptions,
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name'    => 'Explode',
                            'options' => [
                                'validator' =>  [
                                    'name' => 'InArray',
                                    'options' => [
                                        'haystack' => $haystack
                                    ]
                                ]
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                ],
            ]
        ];
        return $fieldset;
    }
}
