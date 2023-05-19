<?php
/**
 * PHP version 7
 * File EditStepViewModel.php
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel\Customer;

use Project\Customer\Front\View\ViewModel\Customer\EditStepViewModel;

/**
 * Class EditStepViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EditStepViewModel extends RegisterStepViewModel
{
    protected $steps   = [
        self::REGISTER => [
            'label' => '会員情報入力',
        ],
        self::REGISTER_CONFIRM => [
            'label' => '会員情報確認',
        ],
        self::REGISTER_FINISH => [
            'label' => '会員情報変更完了',
        ],
    ];
}
