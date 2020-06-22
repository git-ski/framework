<?php
/**
 * PHP version 7
 * File Date.php
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
 * Class Date Element
 * 画面上日付として表記
 *
 * @category Date
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Date extends FormElement
{
    protected $type = 'date';

    /**
     *
     * @param array $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeInput($value, $attr) : string
    {
        $name = $this->getElementName();
        return "<input type='{$this->type}' name='{$name}' value='{$value}' {$attr} />";
    }

    /**
     *
     * @param string  $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeConfirm($value, $attr) : string
    {
        $name = $this->getElementName();
        return "<label class='form_label form_{$this->type}'><input type='hidden' name='{$name}' value='{$value}' />" . $value . "</label>";
    }
}
