<?php
declare(strict_types=1);

namespace Project\Customer\Admin\Fieldset;

use Std\FormManager\Fieldset;
use Std\FormManager\Element;
use Std\FileService\Element\File;
use Std\ValidatorManager\ValidatorInterface;

/**
 * FileRegisterFieldset Fieldset
 */
class FileRegisterFieldset extends Fieldset
{
    protected $name = 'file';

    /**
     * getDefaultFieldset
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [
            'file' => [
                'type'      => File::class,
                'options'   => [
                ],
                'inputSpecification' => [
                    'required'      => true,
                    'validators'    => [
                        [
                            'name' => 'Laminas\Validator\File\Extension',
                            'options' => [
                                'extension' => ['csv'],
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }
}
