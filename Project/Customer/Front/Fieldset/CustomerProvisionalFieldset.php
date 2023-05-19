<?php
declare(strict_types=1);

namespace Project\Customer\Front\Fieldset;

use Std\FormManager\Fieldset;
use Std\RouterManager\RouterManagerAwareInterface;
use Project\Base\Front\Form\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Customer\Model\CustomerTemporaryLModel;
use Project\Customer\Front\Controller\Customer\RegisterModel as CustomerRegisterModel;
use Project\Pages\Front\Controller\Pages\PrivacyController;

/**
 * CustomerProvisionalFieldset
 * 仮登録用Fieldset
 */
class CustomerProvisionalFieldset extends Fieldset implements RouterManagerAwareInterface
{
    use \Std\RouterManager\RouterManagerAwareTrait;

    protected $name = 'customerTemporary';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'customerTemporaryLId' => [
                'type'      => Element\Id::class,
                'options'   => [
                ],
            ],
            // Element\Sessionサンプル
            'type' => [
                'type'      => Element\Session::class,
                'value'     => CustomerTemporaryLModel::getPropertyValue('type', 'CUSTOMERTEMPORARYL_TYPE_CUSTOMER'),
            ],
            'useFlag' => [
                'type'      => Element\Session::class,
                'value'     => CustomerTemporaryLModel::getPropertyValue('useFlag', 'CUSTOMERTEMPORARYL_USEFLAG_OFF'),
            ],
            'email' => [
                'type' => Element\Text::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name' => 'EmailAddress'
                        ],
                        [
                            'name' => 'Callback',
                            'options' =>[
                                'callback' => [$this, 'checkUniqueEmail'],
                                'message' => 'CUSTOMER_CHECK_EMAIL_EXIST_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'input-text nolanguage',
                    'placeholder' =>  CustomerTemporaryLModel::getPropertyLabel('frontEmailPlaceholder'),
                ],
            ],
            'policy' => [
                'type' => Element\Checkbox::class,
                'options' => [
                    'value_options' => [CustomerTemporaryLModel::getPropertyLabel('frontTermsAgreements')],
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty'
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'checkbox',
                ],
            ]
        ];
    }

    // 会員Emailが既に存在するかどうか
    public function checkUniqueEmail($email, $input) : bool
    {
        $CustomerRegisterModel = $this->getObjectManager()->get(CustomerRegisterModel::class);
        $customerId = $input['customerId'] ?? null;
        $Customer = $CustomerRegisterModel->checkCustomerExist([
            'email' => $email
        ], $customerId);
        return !$Customer;
    }
}
