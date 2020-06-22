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
namespace Std\FormManager\Element;

/**
 * Class Id Element
 * 画面上表示しない、単純にsession上idを維持するだけ
 *
 * @category Password
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Session extends FormElementWithSession
{
    /**
     * 要素値をsession上維持する、出力はしない。
     * Fieldsetに固定値をいじする用
     *
     * @param array $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeInput($value, $attr) : string
    {
        return '';
    }

    /**
     * 要素値をsession上維持する、出力はしない。
     * Fieldsetに固定値をいじする用
     *
     * @param array  $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeConfirm($value, $attr) : string
    {
        return '';
    }
}
