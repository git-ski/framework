<?php
/**
 * PHP version 7
 * File EditViewModel.php
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel\Customer;

use Std\ViewModel\AbstractViewModel;
use Project\Customer\Front\View\Layout\MypageLayout;
use Project\Base\Front\View\ViewModel\BreadcrumbViewModel;
use Project\Base\Front\Controller\Front\TopController;
use Project\Customer\Front\Controller\Customer\ProfileController;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;
use Project\Base\Model\VocabularyDetailModel;

/**
 * Class EditViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ProfileViewModel extends AbstractViewModel
{
    protected $template = '/template/customer/profile.twig';

    const AUTHENTICATOR   = 'Authenticator';

    protected $config = [
        'layout' => MypageLayout::class,
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
                            ProfileController::class
                        ]
                    ]
                ]
            ],
            self::AUTHENTICATOR => [
            ],
        ]
    ];

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
    ];

    /**
     * Method onRender
     *
     * @return void
     */
    public function onRender(): void
    {
        $data = $this->getData();
        $data['customer'] = $data['customer']->toArray();
        if (!empty($data['customer']['Prefecture'])) {
            $data['customer']['Prefecture'] = $data['customer']['Prefecture']->toArray();
        }
        $this->setData($data);
    }

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
