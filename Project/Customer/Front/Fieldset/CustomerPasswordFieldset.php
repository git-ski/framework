<?php
declare(strict_types=1);

namespace Project\Customer\Front\Fieldset;

use Std\FormManager\Fieldset;
use Project\Base\Front\Form\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\Customer\Model\CustomerModel;
use Project\Customer\Model\CustomerLModel;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\EntityInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;

/**
 * CustomerUser Fieldset
 */
class CustomerPasswordFieldset extends Fieldset implements
    CryptManagerAwareInterface,
    ConfigManagerAwareInterface
{
    use \Std\CryptManager\CryptManagerAwareTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    const DEFAULT_PASSWORD_DENY_GENERATION = 3;

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
                'type'      => Element\Id::class,
                'options'   => [
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
            'oldPassword' => [
                'type' => Element\Password::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                        [
                            'name' => 'StringTrim'
                        ],
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                        [
                            'name' => 'Callback',
                            'options' =>[
                                'callback' => [$this, 'oldPasswordAuthentication'],
                                'message' => 'PASSWORD_WRONG_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerPasswordOldPlaceholder'),
                ],
            ],
            'customerPassword' => [
                'type' => Element\Password::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                        [
                            'name' => 'StringTrim'
                        ],
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                        // パスワードのバリデーター
                        // まずは、全体として許可する文字：AWS仕様
                        [
                            'name' => 'Regex',
                            'options' => [
                                'pattern' => '/^[\w\!@#\$%\^&\*\(\)\<\>\[\]\{\}\|_\+\-\=]+$/',
                                'message' => 'PASSWORD_COMMON_ERROR_01',
                            ],
                        ],
                        // そして、全体として許可する長さ：AWS仕様
                        // ※Bcryptの仕様上、72bytes以降は無視されるが、将来の新しいパスワードアルゴリズムは128サポートする見通し。
                        // 案件で調整してください。
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'min' => 8,
                                'max' => 128,
                            ]
                        ],
                        [
                            'name' => 'Callback',
                            'options' =>[
                                'callback' => [$this, 'passwordGenerationCheck'],
                                'message'  => 'PASSWORD_GENERATION_ERROR',
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerPasswordNewPlaceholder'),
                ],
            ],
            'customerPasswordConfirm' => [
                'type' => Element\Password::class,
                'options' => [
                ],
                'inputSpecification' => [
                    'required' => true,
                    'filters' => [
                        [
                            'name' => 'StringTrim'
                        ],
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                        ],
                        [
                            'name' => 'Identical',
                            'options' => [
                                'token' => 'customerPassword',
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'input-text nolanguage',
                    'placeholder' => CustomerModel::getPropertyLabel('frontCustomerPasswordNewConfirmPlaceholder'),
                ],
            ],
        ];
    }

    public function oldPasswordAuthentication($oldPassword, $input)
    {
        $customerId    = $input['customerId'];
        $CustomerModel = $this->getObjectManager()->get(CustomerModel::class);
        $Customer      = $CustomerModel->get($customerId);
        if (!$Customer instanceof EntityInterface) {
            return false;
        }
        $Password   = $this->getCryptManager()->getPasswordCrypt();
        return $Password->verify($oldPassword, $Customer->getCustomerPassword());
    }

    public function passwordGenerationCheck($customerPassword, $input)
    {
        if (isset($input['oldPassword']) && $customerPassword === $input['oldPassword']) {
            return false;
        }
        $Config                 = $this->getConfigManager()->getConfig('secure');
        $passwordDenyGeneration = $Config['front']['password_deny_generation'] ?? self::DEFAULT_PASSWORD_DENY_GENERATION;
        $customerId    = $input['customerId'];
        $CustomerLModel= $this->getObjectManager()->get(CustomerLModel::class);

        $CustomerLs    = $CustomerLModel->getList([
            'Customer'   => $customerId,
            'logType' => CustomerLModel::getPropertyValue('logType', 'CUSTOMERL_LOGTYPE_PASSWORD')
        ], null, $passwordDenyGeneration);
        $Password   = $this->getCryptManager()->getPasswordCrypt();
        foreach ($CustomerLs as $CustomerL) {
            if ($Password->verify($customerPassword, $CustomerL->getCustomerPassword())) {
                return false;
            }
        }
        return true;
    }
}
