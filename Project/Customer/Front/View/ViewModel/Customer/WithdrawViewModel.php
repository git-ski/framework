<?php
/**
 * PHP version 7
 * File WithdrawViewModel.php
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel\Customer;

use Std\ViewModel\FormViewModel;
use Project\Customer\Front\View\Layout\MypageLayout;
use Project\Base\Front\View\ViewModel\BreadcrumbViewModel;
use Project\Customer\Front\Fieldset\CustomerWithdrawFieldset;
use Project\Customer\Front\Controller\Customer\WithdrawController;
use Project\Customer\Front\Controller\Customer\ProfileController;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;

/**
 * Class WithdrawViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class WithdrawViewModel extends FormViewModel
{
    protected $template = '/template/customer/withdraw.twig';
    protected $finishTemplate = '/template/customer/withdraw_finish.twig';

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
                            WithdrawController::class
                        ]
                    ]
                ]
            ]
        ]
    ];

    protected $fieldset = [
        CustomerWithdrawFieldset::class
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
        $this->setData($data);
        $form = $this->getForm();
        $form->setData($data);
        $form->submit->setValue($this->getTranslator()->translate('Close account'));
        $form->submit->addClass('button button-contact cancel');
    }
}
