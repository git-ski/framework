<?php
declare(strict_types=1);

namespace Project\Customer\Front\Fieldset;

use Std\FormManager\Fieldset;
use Project\Base\Front\Form\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Customer\Model\CustomerReminderModel;

/**
 * AdminUser Fieldset
 */
class RecoveryFieldset extends Fieldset
{
    protected $name = 'customerReminder';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'customerReminderId' => [
                'type'      => Element\Id::class,
                'options'   => [
                ],
            ],
            'verifyHashKey' => [
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
                            'name' => 'Callback',
                            'options' =>[
                                'callback' => [$this, 'verifyHashKey'],
                                'message' => 'CUSTOMERREMINDER_CHECK_VERIFYHASHKEY_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerReminderModel::getPropertyLabel('frontVerifyHashKeyPlaceholder'),
                ],
            ],
        ];
    }

    public function verifyHashKey($verifyHashKey, $input)
    {
        $CustomerReminderModel = $this->getObjectManager()->get(CustomerReminderModel::class);
        $CustomerReminder      = $CustomerReminderModel->get($input['customerReminderId']);
        return $verifyHashKey === stream_get_contents($CustomerReminder->getVerifyHashKey());
    }
}
