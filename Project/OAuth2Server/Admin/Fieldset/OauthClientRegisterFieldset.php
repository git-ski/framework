<?php
declare(strict_types=1);

namespace Project\OAuth2Server\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;
use Project\OAuth2Server\Entity\OauthClient;
use Project\OAuth2Server\Model\OauthClientModel;
use Project\Base\Helper\VocabularyHelper;

/**
 * OauthClientRegisterFieldset Fieldset
 */
class OauthClientRegisterFieldset extends Fieldset
{
    protected $name = 'oauthClient';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'oauthClientId' => [
                'type'      => Element\Id::class,
                'options'   => [
                    'target' => OauthClient::class,
                    'action' => OauthClientModel::ACTION_CREATE
                ],
            ],
            'name' => [
                'type' => Element\Text::class,
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
                            'name'    => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'max' => 32
                            ]
                        ],
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                    'placeholder' => OauthClientModel::getPropertyLabel('name'),
                ],
            ],
            'redirectUri' => [
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
                    ]
                ],
                'attrs' => [
                    'class'       => 'form-control',
                    'placeholder' => OauthClientModel::getPropertyLabel('redirectUri'),
                ],
            ],
        ];
    }
}
