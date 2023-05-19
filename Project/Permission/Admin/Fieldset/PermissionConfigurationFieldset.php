<?php
declare(strict_types=1);

namespace Project\Permission\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\AclManager\AclManagerAwareInterface;

/**
 * AdminUser Fieldset
 */
class PermissionConfigurationFieldset extends Fieldset implements
    AclManagerAwareInterface
{
    use \Std\AclManager\AclManagerAwareTrait;

    protected $name = 'configuration';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'permission' => [
                'type' => Element\Collection::class,
                'options' => [
                    'target_element' => [
                        'type' => PermissionFieldset::class
                    ]
                ]
            ]
        ];
    }
}
