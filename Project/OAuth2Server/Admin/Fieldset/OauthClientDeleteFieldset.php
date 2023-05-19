<?php
declare(strict_types=1);

namespace Project\OAuth2Server\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element\Id;
use Std\ValidatorManager\ValidatorInterface;
use Project\OAuth2Server\Entity\OauthClient;
use Project\OAuth2Server\Model\OauthClientModel;

/**
 * OauthClientDeleteFieldset
 */
class OauthClientDeleteFieldset extends Fieldset
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
                'type'      => Id::class,
                'options'   => [
                    'target' => OauthClient::class,
                    'action' => OauthClientModel::ACTION_DELETE
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
