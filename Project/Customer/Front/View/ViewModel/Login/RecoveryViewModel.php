<?php
/**
 * PHP version 7
 * File RecoveryViewModel.php
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
use Project\Customer\Front\Fieldset\RecoveryFieldset;
use Project\Customer\Front\Fieldset\RecoveryPasswordFieldset;
use Project\Customer\Front\View\ViewModel\Login\ReminderStepViewModel;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;

/**
 * Class RecoveryViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RecoveryViewModel extends FormViewModel
{
    protected $template = '/template/login/login_recovery.twig';
    protected $finishTemplate = '/template/login/login_recovery_finish.twig';

    protected $config = [
        'layout' => MyPageLayout::class,
        'scripts' => [
        ],
        'styles' => [

        ],
        'container' => [
            'Steps'  => [
                [ 'viewModel' => ReminderStepViewModel::class ],
            ],
        ]
    ];

    protected $fieldset = [
        RecoveryFieldset::class,
        RecoveryPasswordFieldset::class
    ];

    public $listeners = [
        self::TRIGGER_INITED        => 'onInit',
        self::TRIGGER_FORMFINISH    => 'onFinish',
        self::TRIGGER_BEFORE_RENDER => 'onRender',
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

    /**
     * Method onRender
     *
     * @return void
     */
    public function onRender(): void
    {

        $form = $this->getForm();
        $data = $this->getData();
        $data['customerReminder'] = $data['customerReminder']->toArray();
        $data['customer']= $data['customer']->toArray();
        unset($data['customerReminder']['verifyHashKey']);
        $form->setData($data);
        $form->submit->setValue($this->getTranslator()->translate('Resetting your password'));
        if (!$form->isConfirmed()) {
            $form->submit->setAttr('class', 'cv-area-button');
        }
    }

    public function onInit(): void
    {
        $ReminderStepViewModel = $this->getContainer('Steps')->get(ReminderStepViewModel::VIEW_ID);
        $ReminderStepViewModel->setStep(ReminderStepViewModel::REMINDER_REGISTER);
    }

    public function onFinish(): void
    {
        $ReminderStepViewModel = $this->getContainer('Steps')->get(ReminderStepViewModel::VIEW_ID);
        $ReminderStepViewModel->setStep(ReminderStepViewModel::REMINDER_FINISH);
    }
}
