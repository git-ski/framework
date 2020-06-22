<?php
declare(strict_types=1);

namespace Project\Base\Admin\View\ViewModel\Parts;

use Std\ViewModel\AbstractViewModel;

class AlertViewModel extends AbstractViewModel
{
    protected $template = '/template/parts/alert.twig';

    protected $config = [
        'scripts' => [
            '/admin/js/message.js',
        ],
        'styles' => [
            '/admin/css/message.css',
        ],
    ];

    public function getTemplateDir()
    {
        return __DIR__ . '/../..';
    }
}
