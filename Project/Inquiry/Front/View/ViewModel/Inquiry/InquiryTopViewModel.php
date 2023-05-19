<?php
/**
 * PHP version 7
 * File InquiryTopViewModel.php
 *
 * @category ViewModel
 * @package  Project\Pages\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Inquiry\Front\View\ViewModel\Inquiry;

use Std\ViewModel\AbstractViewModel;
use Project\Base\Front\View\Layout\FrontPageLayout;
use Project\Pages\Front\Fieldset\InquiryTopFieldset;
use Project\Base\Front\Controller\Front\TopController;
use Project\Inquiry\Front\Controller\Inquiry\InquiryTopController;
use Project\Base\Front\View\ViewModel\BreadcrumbViewModel;

/**
 * Class InquiryTopViewModel
 *
 * @category ViewModel
 * @package  Project\Pages\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class InquiryTopViewModel extends AbstractViewModel
{
  protected $template = '/template/inquiry/inquiry_top.twig';

    protected $config = [
        'layout' => FrontPageLayout::class,
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
                            TopController::class,
                            InquiryTopController::class
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
    public function getTemplateDir(): string
    {
        return __DIR__ . '/../..';
    }
}
