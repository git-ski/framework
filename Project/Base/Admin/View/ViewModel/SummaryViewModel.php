<?php
declare(strict_types=1);

namespace Project\Base\Admin\View\ViewModel;

use Std\ViewModel\AbstractViewModel;

class SummaryViewModel extends AbstractViewModel
{
    protected $template = '/template/summary.twig';

    protected $config = [
        'scripts' => [
            '/admin/js/vue.example.js',
        ]
    ];

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'checkDashboardStatus',
    ];

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }

    public function checkDashboardStatus()
    {
        $data = [
            'summary' => [
            ]
        ];
        $this->setData($data);
    }
}
