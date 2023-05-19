<?php
declare(strict_types=1);

namespace Project\Permission\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Project\AdminUser\Admin\Authentication\AuthenticationAwareInterface;
use Project\Permission\Model\AdminGroupRModel;
use Project\Permission\Helper\GroupHelper;

/**
 * AdminUser Fieldset
 */
class AdminGroupFieldset extends Fieldset implements AuthenticationAwareInterface
{
    protected $name = 'group';
    use \Std\Authentication\AuthenticationAwareTrait;

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        $GroupHelper    = $this->getObjectManager()->get(GroupHelper::class);
        $GroupList      = $GroupHelper->getGroupList();

        return [
            'groups' => [
                'type' => Element\Select::class,
                'options' => [
                    'empty_option' => '-----',
                    'value_options' => $GroupList
                ],
                'inputSpecification' => [
                    'required' => false,
                    'filters' => [
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty'
                        ],
                        [
                            'name'    => 'Explode',
                            'options' => [
                                'validator' =>  [
                                    'name' => 'InArray',
                                    'options' => [
                                        'haystack' => array_keys($GroupList)
                                    ]
                                ]
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'     => 'form-control',
                ],
            ],
        ];
    }
}
