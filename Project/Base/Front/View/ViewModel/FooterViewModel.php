<?php
declare(strict_types=1);

namespace Project\Base\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;

class FooterViewModel extends AbstractViewModel
{

    protected $template = "/template/footer.twig";

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
