<?php
declare(strict_types=1);

namespace Project\Base\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;

class ContentViewModel extends AbstractViewModel
{

    protected $template = "/template/content.twig";

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
