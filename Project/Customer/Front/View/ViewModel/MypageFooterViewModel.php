<?php
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;
use Project\Customer\Front\View\Layout\MypagePageLayout;

class MypageFooterViewModel extends AbstractViewModel
{

    protected $template = "/template/mypage_footer.twig";

    protected $config = [
        'scripts' => [
        ],
        'styles' => [
        ],
        'container' => [
        ]
    ];

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
