<?php
/**
 * PHP version 7
 * File InquiryStepViewModel.php
 *
 * @category ViewModel
 * @package  Project\Inquiry\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Inquiry\Front\View\ViewModel\Inquiry;

use Project\Base\Front\View\ViewModel\DynamicStepViewModel;

/**
 * Class InquiryStepViewModel
 *
 * @category ViewModel
 * @package  Project\Inquiry\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class InquiryStepViewModel extends DynamicStepViewModel
{
    const VIEW_ID = 'inquiry_step';

    const INQUIRY         = 'inquiry';
    const INQUIRY_CONFIRM = 'inquiry_confirm';
    const INQUIRY_FINISH  = 'inquiry_finish';

    protected $steps   = [
        self::INQUIRY => [
            'label' => 'Input',

        ],
        self::INQUIRY_CONFIRM => [
            'label' => 'Input Content Confirmation',
        ],
        self::INQUIRY_FINISH => [
            'label' => 'Sended',
        ],
    ];

    protected $id = self::VIEW_ID;
}
