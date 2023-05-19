<?php
declare(strict_types=1);

namespace Project\AdminUser\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element\Id;
use Std\ValidatorManager\ValidatorInterface;
use Project\AdminUser\Entity\Admin;
use Project\AdminUser\Model\AdminModel;

/**
 * AdminUser Fieldset
 */
class AdminDeleteFieldset extends Fieldset
{
    protected $name = 'admin';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'adminId' => [
                'type'      => Id::class,
                'options'   => [
                    'target' => Admin::class,
                    'action' => AdminModel::ACTION_DELETE
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
