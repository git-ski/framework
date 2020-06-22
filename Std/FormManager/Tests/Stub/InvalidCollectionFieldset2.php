<?php
declare(strict_types=1);

namespace Std\FormManager\Tests\Stub;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;

/**
 * AdminUser Fieldset
 */
class InvalidCollectionFieldset2 extends Fieldset
{
    protected $name = 'test';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'collection' => [
                'type' => Element\Collection::class,
                'options' => [
                    'label' => 'test',
                    'count' => 5,
                    'allow_add' => true,
                    'allow_remove' => true,
                    'template_placeholder' => '__idx__',
                    'target_element' => $this->getObjectManager()->create(Element\Text::class),
                ],
            ],
        ];
    }
}
