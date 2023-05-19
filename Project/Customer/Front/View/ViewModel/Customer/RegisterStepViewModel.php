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

namespace Project\Customer\Front\View\ViewModel\Customer;

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
class RegisterStepViewModel extends DynamicStepViewModel
{
    const VIEW_ID = 'customer_step';

    const PROVISIONAL           = 'provisional';
    const PROVISIONAL_FINISH    = 'provisional_finish';
    const REGISTER              = 'register';
    const REGISTER_CONFIRM      = 'register_confirm';
    const REGISTER_FINISH       = 'register_finish';

    protected $steps   = [
        self::PROVISIONAL => [
            'label' => 'e-mail',
        ],
        self::PROVISIONAL_FINISH => [
            'label' => 'Pre regist',
        ],
        self::REGISTER => [
            'label' => 'Enter',
        ],
        self::REGISTER_CONFIRM => [
            'label' => 'Confirm',
        ],
        self::REGISTER_FINISH => [
            'label' => 'Registered',
        ],
    ];

    protected $id = self::VIEW_ID;
}
