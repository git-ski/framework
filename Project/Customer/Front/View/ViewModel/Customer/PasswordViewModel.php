<?php
/**
 * PHP version 7
 * File PasswordViewModel.php
 *
 * @category ViewModel
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel\Customer;

use Std\ViewModel\FormViewModel;
use Project\Customer\Front\View\Layout\MypageLayout;
use Project\Customer\Front\Fieldset\CustomerPasswordFieldset;
use Project\Customer\Front\Controller\Customer\ProfileController;
use Project\Customer\Front\Controller\Customer\PasswordController;
use Project\Base\Front\View\ViewModel\BreadcrumbViewModel;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;

/**
 * Class PasswordViewModel
 *
 * @category ViewModel
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class PasswordViewModel extends FormViewModel
{
    protected $template = '/template/customer/password.twig';
    protected $finishTemplate = '/template/customer/password_finish.twig';

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
                            ProfileController::class,
                            PasswordController::class
                        ]
                    ]
                ]
            ]
        ]
    ];

    protected $fieldset = [
        CustomerPasswordFieldset::class
    ];

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
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
    public function getTemplateDir(): string
    {
        return __DIR__ . '/../..';
    }

    /**
     * Method onRender
     *
     * @return void
     */
    public function onRender(): void
    {
        $data = $this->getData();
        $data['customer'] = $data['customer']->toArray();
        $form = $this->getForm();
        $form->setData($data);
        $form->submit->setValue($this->getTranslator()->translate('Change'));
        $form->submit->setAttr('class', 'button button-contact');
    }
}
