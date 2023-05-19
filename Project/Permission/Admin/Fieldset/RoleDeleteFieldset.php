<?php
declare(strict_types=1);

namespace Project\Permission\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element\Id;
use Project\Permission\Entity\Role;
use Project\Permission\Model\RoleModel;

/**
 * AdminUser Fieldset
 */
class RoleDeleteFieldset extends Fieldset
{
    protected $name = 'role';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'roleId' => [
                'type'      => Id::class,
                'options'   => [
                    'target' => Role::class,
                    'action' => RoleModel::ACTION_DELETE
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
