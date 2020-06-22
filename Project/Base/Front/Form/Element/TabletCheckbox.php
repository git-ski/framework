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
class TabletCheckbox extends Checkbox
{
    /**
     * Input要素の生成
     *
     * @param array  $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeInput($value = [], $attr = null): string
    {
        $markup    = [];
        $name    = $this->getElementName();
        $options = $this->getOptions();
        $id      = ucwords(str_replace(['[', ']'], '', $name));
        $value   = (array) $value;
        foreach ($options['value_options'] as $val => $key) {
            $markup[] = "<div class='checkbox checkbox-info col-md-6 m-b-10 h39'>";
            if ($value !== null && in_array($val, $value)) {
                $markup[] = "<input type='{$this->type}' name='{$name}[]' value='{$val}' id='{$id}{$val}' {$attr} checked>";
                $markup[] = "<label class='form_label form_{$this->type}' for='{$id}{$val}'>{$key}</label>";
            } else {
                $markup[] = "<input type='{$this->type}' name='{$name}[]' value='{$val}' id='{$id}{$val}' {$attr}>";
                $markup[] = "<label class='form_label form_{$this->type}' for='{$id}{$val}'>{$key}</label>";
            }
            $markup[] = "</div>";
        }
        return join("", $markup);
    }
}
