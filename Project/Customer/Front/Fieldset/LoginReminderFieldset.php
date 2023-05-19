<?php
declare(strict_types=1);

namespace Project\Customer\Front\Fieldset;

use Std\FormManager\Fieldset;
use Project\Base\Front\Form\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Customer\Model\CustomerModel;

/**
 * AdminUser Fieldset
 */
class LoginReminderFieldset extends Fieldset
{
    protected $name = 'loginReminder';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'email' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                        [
                            'name' => 'Laminas\\Filter\\StringTrim'
                        ]
                    ],
                    'validators' => [
                        [
                            'name' => 'EmailAddress'
                        ],
                        [
                            'name' => 'Callback',
                            'options' =>[
                                'callback' => [$this, 'checkCustomerExist'],
                                'message' => 'CUSTOMER_CHECK_CUSTOMER_EXIST_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontReminderEmailPlaceholder'),
                ],
            ],
        ];
    }

    public function checkCustomerExist($email, $input)
    {
        $input['memberWithdrawDate'] = null;
        return $this->getObjectManager()->get(CustomerModel::class)->getOneBy($input);
    }
}
