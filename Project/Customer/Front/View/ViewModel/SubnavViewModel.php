<?php
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;

class SubnavViewModel extends AbstractViewModel
{
    protected $template = "/template/subnav.twig";

    protected $config = [
        'scripts' => [
        ],
        'styles' => [
        ],
        'container' => [
        ]
    ];


    public function getTemplateDir(): string
    {
        return __DIR__ . '/..';
    }

        /**
     * Method onRender
     *
     * @return void
     */
    public function onRender(): void
    {
        $data = $this->getData();
        $data['qrCode'] = $data['qrCode'];
        $this->setData($data);
    }
}
