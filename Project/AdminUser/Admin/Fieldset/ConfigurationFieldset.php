<?php
declare(strict_types=1);

namespace Project\AdminUser\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\ValidatorManager\ValidatorInterface;

/**
 * ConfigurationFieldset
 */
class ConfigurationFieldset extends Fieldset
{
    protected $name = 'configuration';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
        ];
    }
}
