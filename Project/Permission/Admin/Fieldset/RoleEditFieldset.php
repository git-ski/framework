<?php
declare(strict_types=1);

namespace Project\Permission\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Project\Permission\Entity\Role;
use Project\Permission\Model\RoleModel;

/**
 * AdminUser Fieldset
 */
class RoleEditFieldset extends Fieldset
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
            'roleId' => [
                'type'      => Element\Id::class,
                'options'   => [
                    'target' => Role::class,
                    'action' => RoleModel::ACTION_UPDATE
                ],
                'inputSpecification' => [
                    'required'      => true,
                    'validators'    => [
                        [
                            'name'  => 'NotEmpty',
                        ],
                    ]
                ]
            ],
            'role' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [

                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                        [
                            'name' => 'Regex',
                            'options' => [
                                'pattern' => '/^[\wあ-んァ-ヾ一-龠]+$/',
                            ],
                        ],
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'min' => 2,
                                'max' => 32,
                            ]
                        ],
                        [
                            'name' => 'Callback',
                            'options' => [
                                'callback' => [$this, 'checkRoleExist'],
                                'message' => $this->getTranslator()->translate('CHECK_ROLE_EXIST_ERROR'),
                            ],
                        ]
                    ],
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => RoleModel::getPropertyLabel('role'),
                ],
            ],
        ];
    }

    /**
     * Undocumented function
     *
     * @param string $value
     * @return bool
     */
    public function checkRoleExist($value, $input) :bool
    {
        $RoleModel = $this->getObjectManager()->get(RoleModel::class);
        $Role = $RoleModel->getRepository()->findOneBy(
            [
                'deleteFlag' => 0,
                'role' => $value
            ]
        );

        if($Role){
            if($input['roleId'] == $Role->getroleId()){
                return true;
            }
        }

        return !$Role;
    }
}
