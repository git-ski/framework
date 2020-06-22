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
namespace Std\FormManager\Element;

/**
 * Class Radio
 *
 * @category Radio
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Radio extends FormElement
{
    protected $type = 'radio';

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
        foreach ($options['value_options'] as $val => $key) {
            if ($value !== null && $val == $value) {
                $markup[] = "<div class='{$this->type} {$this->type}-info'>";
                $markup[] = "<input type='{$this->type}' name='{$name}' value='{$val}' id='{$id}{$val}' {$attr} checked />";
                $markup[] = "<label class='form_label form_{$this->type}' for='{$id}{$val}'>{$key}</label>";
                $markup[]  = '</div>';
            } else {
                $markup[] = "<div class='{$this->type} {$this->type}-info'>";
                $markup[] = "<input type='{$this->type}' name='{$name}' value='{$val}' id='{$id}{$val}' {$attr} />";
                $markup[] = "<label class='form_label form_{$this->type}' for='{$id}{$val}'>{$key}</label>";
                $markup[]  = '</div>';
            }
        }
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
        $markup    = [];
        $name    = $this->getElementName();
        $options = $this->getOptions();
        foreach ($options['value_options'] as $val => $key) {
            if ($value !== null && $val == $value) {
                $markup[] = "<input type='hidden' name='{$name}' value='{$val}'>";
                $markup[] = "<label class='form_label form_{$this->type}'>{$key}</label>";
                break;
            }
        }
        return join("", $markup);
    }
}
