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
class Id extends FormElementWithSession
{
    /**
     * IDは、更新対象のidをsession上維持するだけ、要素自体出力必要がない
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
     * IDは、更新対象のidをsession上維持するだけ、要素自体出力必要がない
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
