<?php
declare(strict_types=1);

namespace Project\Language\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;

class LanguageViewModel extends AbstractViewModel
{
    protected $template = '/template/language.twig';

    protected $id = __CLASS__;

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
