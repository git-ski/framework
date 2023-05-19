<?php
/**
 * PHP version 7
 * File RegisterViewModel.php
 *
 * @category ViewModel
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Admin\View\ViewModel\Customer;

use Std\ViewModel\FormViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\Customer\Admin\Fieldset\CustomerRegisterFieldset;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;

/**
 * Class RegisterViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterViewModel extends FormViewModel
{
    protected $template = '/template/customer/register.twig';
    protected $confirmTemplate = '/template/customer/register.twig';
    protected $finishTemplate = null;

    protected $config = [
        'layout' => AdminPageLayout::class,
        'scripts' => [
            '/common/js/zipcode_search.js',
        ],
        'styles' => [
        ],
        'container' => [
            'Breadcrumb' => [
                [
                    'viewModel' => BreadcrumbViewModel::class,
                ]
            ],
        ],
    ];

    protected $fieldset = [
        CustomerRegisterFieldset::class
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
        $data['customer']['login'] = $this->getCryptManager()->getRandomString()->generate(8);
        $form = $this->getForm();
        $form->submit->addClass('btn btn-block bg-deep-orange');
        $form->submit->setValue('登録する');
        if (!$form->isConfirmed()) {
            $form->submit->setValue('確認する');
        }
        $form->setData($data);
    }
}
