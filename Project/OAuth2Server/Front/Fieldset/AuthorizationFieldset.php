<?php
declare(strict_types=1);

namespace Project\OAuth2Server\Front\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;

/**
 * AuthorizationFieldset
 */
class AuthorizationFieldset extends Fieldset
{
    protected $name = 'authorization';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'approve' => [
                'type' => Element\Submit::class,
            ],
        ];
    }
}
