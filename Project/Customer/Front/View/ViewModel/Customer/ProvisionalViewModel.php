<?php
/**
 * PHP version 7
 * File ProvisionalViewModel.php
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
use Project\Customer\Front\Fieldset\CustomerProvisionalFieldset;
use Project\Customer\Front\View\ViewModel\Customer\PolicyViewModel;
use Project\Customer\Front\View\ViewModel\Customer\RegisterStepViewModel;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;

/**
 * Class ProvisionalViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ProvisionalViewModel extends FormViewModel
{
    protected $template = '/template/customer/provisional.twig';
    protected $finishTemplate = '/template/customer/provisional_finish.twig';

    protected $config = [
        'layout' => MypageLayout::class,
        'scripts' => [
        ],
        'styles' => [
        ],
        'container' => [
            'Steps'  => [
                [ 'viewModel' => RegisterStepViewModel::class ],
            ],
            'Policy' => [
                [ 'viewModel' => PolicyViewModel::class ],
            ]
        ]
    ];

    protected $fieldset = [
        CustomerProvisionalFieldset::class
    ];

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
        self::TRIGGER_INITED        => 'onInit',
        self::TRIGGER_FORMFINISH  => 'onFinish',
    ];

    public function getRenderer() : RendererInterface
    {
        return $this->getObjectManager()->get(TwigRenderer::class);
    }

    /**
     * Formが持っているElementをObjectとして、扱うサンプル。
     *
     * @return void
     */
    public function onRender(): void
    {
        $form = $this->getForm();
        $form->submit->setValue($this->getTranslator()->translate('Send'));
        $form->submit->setAttr('class', 'button button-contact');
    }

    public function onInit(): void
    {
        $RegisterStepViewModel = $this->getContainer('Steps')->get(RegisterStepViewModel::VIEW_ID);
        $RegisterStepViewModel->setStep(RegisterStepViewModel::PROVISIONAL);
    }

    public function onFinish(): void
    {
        $RegisterStepViewModel = $this->getContainer('Steps')->get(RegisterStepViewModel::VIEW_ID);
        $RegisterStepViewModel->setStep(RegisterStepViewModel::PROVISIONAL_FINISH);
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
