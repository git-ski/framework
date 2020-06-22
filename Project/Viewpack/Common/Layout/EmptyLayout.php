<?php

namespace Project\Viewpack\Common\Layout;

use Std\ViewModel\PageLayout;

class EmptyLayout extends PageLayout
{
    protected $template = '/template/layout/empty.twig';

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
