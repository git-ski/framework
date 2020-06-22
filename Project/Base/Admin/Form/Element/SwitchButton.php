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
namespace Project\Base\Admin\Form\Element;

use Std\FormManager\FormManager;

/**
 * Class Radio
 *
 * @category Radio
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class SwitchButton extends Checkbox
{
    const VALUE_OFF = 0;
    const VALUE_ON  = 1;

    /**
     * Input要素の生成
     *
     * @param array  $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeInput($value, $attr) : string
    {
        $markup     = [];
        $name       = $this->getElementName();
        $options    = $this->getOptions();
        $valueOptions = $options['value_options'];
        $valueOn    = self::VALUE_ON;
        assert(
            array_keys($valueOptions) == [self::VALUE_OFF, self::VALUE_ON],
            sprintf('%s flag以外の選択肢はcheckbox・selectなどを利用してください', $name)
        );
        $leverAttrs = $options['lever_attrs'] ?? [];
        $leverAttrs['class'] = $leverAttrs['class'] ?? '';
        $leverAttrs['class'] .= ' lever';
        $leverAttrs = FormManager::attrFormat($leverAttrs);
        $checked    = (self::VALUE_ON == $value) ? 'checked' : '';
        $id         = ucwords(str_replace(['[', ']'], '', $name));
        $markup[]   = "<div class='switch'><label>";
        if (isset($valueOptions[0])) {
            $markup[]   = '<small>' . $valueOptions[0] . '</small>';
        }
        $markup[]   = "<input type='{$this->type}' name='{$name}' value='{$valueOn}' {$checked} {$attr}>";
        $markup[]   = "<span {$leverAttrs}></span>";
        if (isset($valueOptions[1])) {
            $markup[]   = '<small>' . $valueOptions[1] . '</small>';
        }
        $markup[]   = "</label></div>";
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
        $markup     = [];
        $name       = $this->getElementName();
        $options    = $this->getOptions();
        $valueOptions = $options['value_options'];
        $valueOn    = self::VALUE_ON;
        $leverAttrs = $options['lever_attrs'] ?? [];
        $leverAttrs['class'] = $leverAttrs['class'] ?? '';
        $leverAttrs['class'] .= ' lever';
        $leverAttrs = FormManager::attrFormat($leverAttrs);
        $checked    = (self::VALUE_ON == $value) ? 'checked' : '';
        $id         = ucwords(str_replace(['[', ']'], '', $name));
        $markup[]   = "<div class='switch'><label>";
        if (isset($valueOptions[0])) {
            $markup[]   = '<small>' . $valueOptions[0] . '</small>';
        }
        $markup[]   = "<input type='{$this->type}' name='{$name}' value='{$valueOn}' {$checked} {$attr} disabled>";
        $markup[]   = "<span {$leverAttrs}></span>";
        if (isset($valueOptions[1])) {
            $markup[]   = '<small>' . $valueOptions[1] . '</small>';
        }
        $markup[]   = "</label></div>";
        return join("", $markup);
    }
}
