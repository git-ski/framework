<?php
declare(strict_types=1);

namespace Project\AdminUser\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\AdminUser\Entity\Admin;
use Project\AdminUser\Model\AdminModel;
use Project\AdminUser\Model\AdminLModel;
use Std\EntityManager\EntityInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Project\AdminUser\Admin\Authentication\AuthenticationAwareInterface;

/**
 * AdminUser Fieldset
 */
class AdminPasswordFieldset extends Fieldset implements
    AuthenticationAwareInterface,
    ConfigManagerAwareInterface
{
    use \Std\Authentication\AuthenticationAwareTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    const DEFAULT_PASSWORD_DENY_GENERATION = 3;

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
                'type'      => Element\Id::class,
                'options'   => [
                    'target' => Admin::class,
                    'action' => AdminModel::ACTION_UPDATE
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
                                'message' => $this->getTranslator()->translate('PASSWORD_WRONG_ERROR'),
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => AdminModel::getPropertyLabel('adminPassword'),
                ],
            ],
            'adminPassword' => [
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
                    'class'       => 'form-control nolanguage',
                    'placeholder' => AdminModel::getPropertyLabel('adminPassword'),
                ],
            ],
            'adminPasswordConfirm' => [
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
                                'token' => 'adminPassword',
                            ],
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control nolanguage',
                    'placeholder' => AdminModel::getPropertyLabel('adminPasswordConfirm'),
                ],
            ],
        ];
    }

    public function oldPasswordAuthentication($oldPassword, $input)
    {
        $adminId    = $input['adminId'];
        $AdminModel = $this->getObjectManager()->get(AdminModel::class);
        $Admin      = $AdminModel->get($adminId);
        if (!$Admin instanceof EntityInterface) {
            return false;
        }
        $Password   = $this->getAuthentication()->getAdapter()->getCrypt();
        return $Password->verify($oldPassword, $Admin->getAdminPassword());
    }

    public function passwordGenerationCheck($adminPassword, $input)
    {
        if (isset($input['oldPassword']) && $adminPassword === $input['oldPassword']) {
            return false;
        }
        $Config                 = $this->getConfigManager()->getConfig('secure');
        $passwordDenyGeneration = $Config['admin']['password_deny_generation'] ?? self::DEFAULT_PASSWORD_DENY_GENERATION;
        $adminId    = $input['adminId'];
        $AdminLModel= $this->getObjectManager()->get(AdminLModel::class);

        $AdminLs    = $AdminLModel->getList([
            'Admin'   => $adminId,
            'logType' => AdminLModel::getPropertyValue('logType', 'ADMINL_LOGTYPE_PASSWORD')
        ], null, $passwordDenyGeneration);
        $Password   = $this->getAuthentication()->getAdapter()->getCrypt();
        foreach ($AdminLs as $AdminL) {
            if ($Password->verify($adminPassword, $AdminL->getAdminPassword())) {
                return false;
            }
        }
        return true;
    }
}
