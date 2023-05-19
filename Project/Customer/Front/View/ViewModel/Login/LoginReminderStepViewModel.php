<?php
/**
 * PHP version 7
 * File RegisterStepViewModel.php
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel\Login;

use Project\Customer\Front\View\ViewModel\Login\ReminderStepViewModel;

/**
 * Class RegisterStepViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class LoginReminderStepViewModel extends ReminderStepViewModel
{
    protected $steps   = [
        self::REMINDER_ENTRY => [
            'label' => 'Input',
        ],
        self::REMINDER_ENTRY_FINISH => [
            'label' => 'Sended',
        ],
    ];

    public $listeners = [
        self::TRIGGER_INITED        => 'onInit',
        self::TRIGGER_FORMFINISH    => 'onFinish',
    ];

    public function onInit(): void
    {
        $this->setStep(self::REMINDER_ENTRY);
    }

    public function onFinish(): void
    {
        $this->setStep(self::REMINDER_ENTRY_FINISH);
    }
}
