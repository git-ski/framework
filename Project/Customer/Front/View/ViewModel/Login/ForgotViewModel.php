<?php
/**
 * PHP version 7
 * File ForgotViewModel.php
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel\Login;

use Std\ViewModel\FormViewModel;
use Project\Customer\Front\View\Layout\MyPageLayout;
use Project\Customer\Front\Fieldset\ForgotFieldset;
use Project\Customer\Front\View\ViewModel\Login\ReminderStepViewModel;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;

/**
 * Class ForgotViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ForgotViewModel extends FormViewModel
{
    protected $template = '/template/login/login_forgot.twig';
    protected $finishTemplate = '/template/login/login_forgot_finish.twig';

    protected $config = [
        'layout' => MyPageLayout::class,
        'scripts' => [
        ],
        'styles' => [

        ],
        'container' => [
            'Steps'  => [
                [ 'viewModel' => ReminderStepViewModel::class ],
            ]
        ]
    ];

    protected $fieldset = [
        ForgotFieldset::class
    ];

    public $listeners = [
        self::TRIGGER_INITED        => 'onInit',
        self::TRIGGER_FORMFINISH  => 'onFinish',
        self::TRIGGER_BEFORE_RENDER => 'onRender',
    ];

    public function getRenderer() : RendererInterface
    {
        return $this->getObjectManager()->get(TwigRenderer::class);
    }

    public function onRender(): void
    {

        $form = $this->getForm();
        $form->submit->setValue($this->getTranslator()->translate('Send'));
        if (!$form->isConfirmed()) {
            $form->submit->setAttr('class', 'cv-area-button');
        }
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

    public function onInit(): void
    {
        $ReminderStepViewModel = $this->getContainer('Steps')->get(ReminderStepViewModel::VIEW_ID);
        $ReminderStepViewModel->setStep(ReminderStepViewModel::REMINDER_ENTRY);
    }

    public function onFinish(): void
    {
        $ReminderStepViewModel = $this->getContainer('Steps')->get(ReminderStepViewModel::VIEW_ID);
        $ReminderStepViewModel->setStep(ReminderStepViewModel::REMINDER_ENTRY_FINISH);
    }
}
