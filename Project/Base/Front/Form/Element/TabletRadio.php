<?php
/**
 * PHP version 7
 * File Radio.php
 *
 * @category FormElement
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Front\Form\Element;

class TabletRadio extends Radio
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
        $idx      = 0;
        foreach ($options['value_options'] as $val => $key) {
            $idx++;
            $colOffset = "";
            if ($idx === 1) {
                $colOffset = "col-md-offset-1 ";
            }

            $markup[] = "<div class='radio radio-info col-md-3 {$colOffset}col-xs-3 m-t-10'>";
            if ($value !== null && $val == $value) {
                $markup[] = "<input type='{$this->type}' name='{$name}' value='{$val}' id='{$id}{$val}' {$attr} checked>";
                $markup[] = "<label class='form_label form_{$this->type}' for='{$id}{$val}'>{$key}</label>";
            } else {
                $markup[] = "<input type='{$this->type}' name='{$name}' value='{$val}' id='{$id}{$val}' {$attr}>";
                $markup[] = "<label class='form_label form_{$this->type}' for='{$id}{$val}'>{$key}</label>";
            }
            $markup[] = '</div>';
        }
        return join("", $markup);
    }
}
