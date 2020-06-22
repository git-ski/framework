<?php
/**
 * PHP version 7
 * File Select.php
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
 * Class Select
 *
 * @category Select
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Select extends FormElement
{
    protected $type = 'select';

    /**
     * Input要素の生成
     *
     * @param array  $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeInput($value, $attr) : string
    {
        $name    = $this->getElementName();
        $markup    = ["<select name='{$name}' {$attr}>"];
        $options = $this->getOptions();
        if (isset($options['empty_option'])) {
            $markup[] = "<option value=''>" . $options['empty_option'] . "</option>";
        }
        foreach ($options['value_options'] as $val => $key) {
            if ($value !== null && $val == $value) {
                $markup[] = "<option value='{$val}' selected>" . $key . "</option>";
            } else {
                $markup[] = "<option value='{$val}'>" . $key . "</option>";
            }
        }
        $markup[] = "</select>";
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
        $markup    = "";
        $name    = $this->getElementName();
        $options = $this->getOptions();
        foreach ($options['value_options'] as $val => $key) {
            if ($value !== null && $val == $value) {
                $markup = "<label class='form_label form_{$this->type}'><input type='hidden' name='{$name}' value='{$value}'>" . $key . "</label>";
                break;
            }
        }
        return $markup;
    }
}
