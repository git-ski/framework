<?php
/**
 * PHP version 7
 * File Checkbox.php
 *
 * @category FormElement
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Project\Base\Front\Form\Element;

/**
 * Class Checkbox
 *
 * @category Checkbox
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class CheckboxInConfirm extends Checkbox
{
    public function makeConfirm($value = [], $attr = null) :string
    {
        return $this->makeInput($value, $attr);
    }
}
