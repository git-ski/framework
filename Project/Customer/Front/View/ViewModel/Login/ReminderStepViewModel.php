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

use Project\Base\Front\View\ViewModel\DynamicStepViewModel;

/**
 * Class RegisterStepViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ReminderStepViewModel extends DynamicStepViewModel
{
    const VIEW_ID = 'reminder_step';

    const REMINDER_ENTRY        = 'reminder_entry';
    const REMINDER_ENTRY_FINISH = 'reminder_entry_finish';
    const REMINDER_REGISTER     = 'reminder_register';
    const REMINDER_FINISH       = 'reminder_finish';

    protected $steps   = [
        self::REMINDER_ENTRY => [
            'label' => 'Input',
        ],
        self::REMINDER_ENTRY_FINISH => [
            'label' => 'Sended',
        ],
        self::REMINDER_REGISTER => [
            'label' => 'Resetting',
        ],
        self::REMINDER_FINISH => [
            'label' => 'Changed',
        ],
    ];

    protected $id = self::VIEW_ID;
}
