<?php
declare(strict_types=1);

namespace Project\Language\Admin\View\ViewModel;

use Std\ViewModel\AbstractViewModel;

class LanguageViewModel extends AbstractViewModel
{
    protected $template = '/template/language.twig';

    protected $id = __CLASS__;

    protected $config = [
        'scripts' => [
            '/admin/js/language.js',
        ],
        'styles' => [

        ],
    ];

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
