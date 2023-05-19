<?php
declare(strict_types=1);

namespace Project\Permission\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\AclManager\AclManagerAwareInterface;

/**
 * AdminUser Fieldset
 */
class PermissionFieldset extends Fieldset implements
    AclManagerAwareInterface
{
    use \Std\AclManager\AclManagerAwareTrait;

    protected $name = 'permissionConfiguration';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        $fieldset = [
            '__roleId__' => [
                'type' => Element\Id::class,
            ]
        ];
        $AclManager = $this->getAclManager();
        foreach ($AclManager->getResourcePrivilegeFixed() as $ResourcePrivilege) {
            $permission = $ResourcePrivilege['permission'];
            $fieldset[$permission] =  [
                'type' => Element\Checkbox::class,
                'options' => [
                    'value_options' => [1 => '許可'],
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty'
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                ],
            ];
        }
        return $fieldset;
    }
}
