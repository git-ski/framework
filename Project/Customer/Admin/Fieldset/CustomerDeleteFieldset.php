<?php
declare(strict_types=1);

namespace Project\Customer\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element\Id;
use Std\ValidatorManager\ValidatorInterface;
use Project\Customer\Entity\Customer;
use Project\Customer\Model\CustomerModel;

/**
 * CustomerDeleteFieldset
 */
class CustomerDeleteFieldset extends Fieldset
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
            'customerId' => [
                'type'      => Id::class,
                'options'   => [
                    'target' => Customer::class,
                    'action' => CustomerModel::ACTION_DELETE
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
