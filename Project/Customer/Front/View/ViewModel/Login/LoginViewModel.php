<?php
/**
 * PHP version 7
 * File LoginViewModel.php
 *
 * @category ViewModel
 * @package  Project\Base\AdminUser
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel\Login;

use Std\ViewModel\FormViewModel;
use Project\Base\Front\View\Layout\FrontPageLayout;
use Project\Customer\Front\View\Layout\MyPageLayout;
use Project\Customer\Front\Fieldset\CustomerLoginFieldset;
use Project\Customer\Front\Controller\Login\LoginController;
use Project\Base\Front\View\ViewModel\BreadcrumbViewModel;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;

/**
 * Class LoginViewModel
 *
 * @category LoginViewModel
 * @package  Project\Base\AdminUser
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class LoginViewModel extends FormViewModel
{
    protected $template = '/template/login/login.twig';

    protected $config = [
        'layout' => MyPageLayout::class,
        'scripts' => [
        ],
        'styles' => [
            // '/plugins/bower_components/register-steps/steps.css',
        ],
        'container' => [
            'Breadcrumb' => [
                [
                    'viewModel' => BreadcrumbViewModel::class,
                    'data'      => [
                        'breadcrumbs' => [
                            LoginController::class
                        ]
                    ]
                ]
            ]
        ]
    ];

    protected $fieldset = [
        CustomerLoginFieldset::class
    ];

    public function getRenderer() : RendererInterface
    {
        return $this->getObjectManager()->get(TwigRenderer::class);
    }

    /**
     * Method GetTemplateDir
     *
     * @return string templateDir
     */
    public function getTemplateDir()
    {
        return __DIR__ . '/../..';
    }

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
        $form = $this->getForm();
        $form->submit->setValue($this->getTranslator()->translate('Next'));
        $form->submit->setAttr('class', 'button button-contact');
        $form->submit->setAttr('tabindex', '3');
    }
}

