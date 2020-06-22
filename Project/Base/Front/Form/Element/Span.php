<?php
/**
 * PHP version 7
 * File Password.php
 *
 * @category FormElement
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Project\Base\Front\Form\Element;

use Std\FormManager\Element\Span as StdSpan;

class Span extends StdSpan
{
    /**
     *
     * @param array $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeInput($value, $attr) : string
    {
        return "<div><label>" . $value . '</label></div>';
    }

    /**
     *
     * @param array  $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeConfirm($value, $attr) : string
    {
        return "<div><label>" . $value . '</label></div>';
    }
}
