<?php
/**
 * PHP version 7
 * File Textarea.php
 *
 * @category FormElement
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Project\Base\Admin\Form\Element;

use Std\FormManager\Element\FormElement;

class WisyTextarea extends FormElement
{
    protected $type = 'textarea';

    /**
     * Input要素の生成
     *
     * @param array  $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeInput($value, $attr) : string
    {
        $name = $this->getElementName();
        $markup = [
            "<textarea name='{$name}' {$attr}>",
            $value,
            "</textarea>"
        ];
        return join("", $markup);
    }

    /**
     * 確認用要素の生成
     *
     * @param string  $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeConfirm($value, $attr) : string
    {
        $name = $this->getElementName();
        return "<div><label class='form_label form_{$this->type}'><input type='hidden' name='{$name}' value='{$value}'>" . nl2br(htmlspecialchars_decode($value, ENT_QUOTES)) . "</label></div>";
    }
}
