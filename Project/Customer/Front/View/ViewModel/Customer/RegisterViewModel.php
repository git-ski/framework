<?php
/**
 * PHP version 7
 * File RegisterViewModel.php
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
use Project\Customer\Front\Fieldset\CustomerRegisterFieldset;
use Project\Customer\Front\View\ViewModel\Customer\RegisterStepViewModel;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;

/**
 * Class RegisterViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterViewModel extends FormViewModel
{
    protected $template = '/template/customer/register.twig';
    protected $confirmTemplate = '/template/customer/register_confirm.twig';
    protected $finishTemplate = '/template/customer/register_finish.twig';

    protected $config = [
        'layout' => MypageLayout::class,
        'scripts' => [
            '/common/js/zipcode_search.js',
        ],
        'styles' => [
        ],
        'container' => [
            'Steps'  => [
                [ 'viewModel' => RegisterStepViewModel::class ],
            ],
        ]
    ];

    protected $fieldset = [
        CustomerRegisterFieldset::class
    ];

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
        self::TRIGGER_INITED        => 'onInit',
        self::TRIGGER_FORMCONFIRM   => 'onConfirm',
        self::TRIGGER_FORMFINISH  => 'onFinish',
    ];

    public function getRenderer() : RendererInterface
    {
        return $this->getObjectManager()->get(TwigRenderer::class);
    }

    /**
     * Method onRender
     *
     * @return void
     */
    public function onRender(): void
    {
        $form = $this->getForm();
        $data = $this->getData();
        $data['customer'] = $data['customer']->toArray();
        if(!empty($data['defaultCountry'])){
           $data['customer']['Country'] = $data['defaultCountry'];//set country is Japan
        }
        $form->submit->setValue($this->getTranslator()->translate('Create'));
        $form->reset->setValue($this->getTranslator()->translate('Back'));
        $form->setData($data);
        if (!$form->isConfirmed()) {
            $form->submit->setValue($this->getTranslator()->translate('Confirm '));
            $form->submit->setAttr('class', 'cv-area-button');
        }
    }

    public function onInit(): void
    {
        $this->getContainer('Steps')->get(RegisterStepViewModel::VIEW_ID)
            ->setStep(RegisterStepViewModel::REGISTER);
    }

    public function onConfirm(): void
    {
        $this->getContainer('Steps')->get(RegisterStepViewModel::VIEW_ID)
            ->setStep(RegisterStepViewModel::REGISTER_CONFIRM);
        $form = $this->getForm();
        $form->reset->setAttr('class', 'button button-border');
        $form->submit->setAttr('class', 'button button-contact');
    }

    public function onFinish(): void
    {
        $this->getContainer('Steps')->get(RegisterStepViewModel::VIEW_ID)
            ->setStep(RegisterStepViewModel::REGISTER_FINISH);
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
