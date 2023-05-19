<?php
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;

class FooterViewModel extends AbstractViewModel
{

    protected $template = "/template/footer.twig";

    const FOOTER_LOGIN  = 'LoginFooter';
    const FOOTER_MYPAGE = 'MypageFooter';

    protected $config = [
        'scripts' => [
        ],
        'styles' => [
        ],
        'container' => [
           self::FOOTER_LOGIN  => [
            ],

            self::FOOTER_MYPAGE => [
            ],
        ]
    ];

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
