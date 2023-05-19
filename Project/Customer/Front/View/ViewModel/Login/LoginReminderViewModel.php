<?php
/**
 * PHP version 7
 * File LoginReminderViewModel.php
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
use Project\Customer\Front\Fieldset\LoginReminderFieldset;
use Project\Customer\Front\View\ViewModel\Login\LoginReminderStepViewModel;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;

/**
 * Class LoginReminderViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class LoginReminderViewModel extends FormViewModel
{
    protected $template = '/template/login/login_reminder.twig';
    protected $finishTemplate = '/template/login/login_reminder_finish.twig';

    protected $config = [
        'layout' => MyPageLayout::class,
        'scripts' => [
        ],
        'styles' => [

        ],
        'container' => [
            'Steps'  => [
                [ 'viewModel' => LoginReminderStepViewModel::class ],
            ]
        ]
    ];

    protected $fieldset = [
        LoginReminderFieldset::class
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

        $form = $this->getForm();
        $form->submit->setValue($this->getTranslator()->translate('Send'));
        if (!$form->isConfirmed()) {
            $form->submit->setAttr('class', 'cv-area-button');
        }

    }
}
