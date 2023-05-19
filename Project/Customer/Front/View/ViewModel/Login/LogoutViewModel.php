<?php
/**
 * PHP version 7
 * File LogoutViewModel.php
 *
 * @category ViewModel
 * @package  Project\Base\AdminUser
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel\Login;

use Std\ViewModel\AbstractViewModel;
use Project\Customer\Front\View\Layout\MyPageLayout;
use Project\Customer\Front\Controller\Login\LogoutController;
use Project\Base\Front\View\ViewModel\BreadcrumbViewModel;

/**
 * Class LogoutViewModel
 *
 * @category LogoutViewModel
 * @package  Project\Base\AdminUser
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class LogoutViewModel extends AbstractViewModel
{
    protected $template = '/template/login/logout.twig';

    protected $config = [
        'layout' => MyPageLayout::class,
        'scripts' => [
        ],
        'styles' => [
        ],
        'container' => [
            'Breadcrumb' => [
                [
                    'viewModel' => BreadcrumbViewModel::class,
                    'data'      => [
                        'breadcrumbs' => [
                            LogoutController::class
                        ]
                    ]
                ]
            ]
        ]
    ];

    /**
     * Method GetTemplateDir
     *
     * @return string templateDir
     */
    public function getTemplateDir()
    {
        return __DIR__ . '/../..';
    }
}

