<?php
/**
 * PHP version 7
 * File InLineRadio.php
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
 * Class InLineRadio
 *
 * @category InLineRadio
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class InLineRadio extends Radio
{
    /**
     * Input要素の生成
     *
     * @param array  $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeInput($value, $attr) : string
    {
        $markup    = [];
        $name    = $this->getElementName();
        $options = $this->getOptions();
        $id      = ucwords(str_replace(['[', ']'], '', $name));
        $markup[] = "<div class='radio radio-info'>";
        foreach ($options['value_options'] as $val => $key) {
            if ($value !== null && $val == $value) {
                $markup[] = "<input type='radio' name='{$name}' value='{$val}' id='{$id}{$val}' {$attr} checked />";
                $markup[] = "<label class='form_label form_radio' for='{$id}{$val}'>{$key}</label>";
            } else {
                $markup[] = "<input type='radio' name='{$name}' value='{$val}' id='{$id}{$val}' {$attr} />";
                $markup[] = "<label class='form_label form_radio' for='{$id}{$val}'>{$key}</label>";
            }
        }
        $markup[]  = '</div>';
        return join("", $markup);
    }

    /**
     * 確認用要素の生成
     *
     * @param array  $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeConfirm($value, $attr) : string
    {
        $markup    = '';
        $name    = $this->getElementName();
        $options = $this->getOptions();
        foreach ($options['value_options'] as $val => $key) {
            if ($value !== null && $val == $value) {
                $markup = "<label class='form_label form_radio'><input type='hidden' name='{$name}' value='{$value}'>{$key}</label>";
                break;
            }
        }
        return $markup;
    }
}
