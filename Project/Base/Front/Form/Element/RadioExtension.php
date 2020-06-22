<?php
/**
 * PHP version 7
 * File RadioExtension.php
 *
 * @category FormElement
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Project\Base\Front\Form\Element;

use Std\FormManager\Element\Radio as StdRadio;
class RadioExtension extends StdRadio
{
    protected $itemDefaultOptions = [
        'has_item' => false,
        'class' => null,
    ];

    protected $nameDefaultOptions = [
        'has_name' => true,
        'is_inside' => true,
        'class' => null,
    ];

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
        $itemOptions    = ($options['item_options'] ?? []) + $this->itemDefaultOptions;
        $nameOptions    = ($options['name_options'] ?? []) + $this->nameDefaultOptions;
        $id         = ucwords(str_replace(['[', ']'], '', $name));
        foreach ($options['value_options'] as $val => $key) {
            if ($value !== null && $val == $value) {
                if ($itemOptions['has_item']) {
                    $markup[] = "<div class='{$itemOptions['class']}'>";
                }
                $markup[] = "<input type='{$this->type}' name='{$name}' value='{$val}' id='{$id}{$val}' {$attr} checked>";
                if ($nameOptions['has_name'] && $nameOptions['is_inside']) {
                    $markup[] = "<label for='{$id}{$val}'><img src='{$key['img']}' /><span class='{$nameOptions['class']}'>{$key['label']}</span></label>";
                } else {
                    $markup[] = "<label for='{$id}{$val}'><img src='{$key['img']}' /></label>";
                    if ($nameOptions['has_name'] && !$nameOptions['is_inside']) {
                        $markup[] = "<span class='{$nameOptions['class']}'>{$key['label']}</span>";
                    }
                }
                if ($itemOptions['has_item']) {
                    $markup[] = "</div>";
                }
            } else {
                if ($itemOptions['has_item']) {
                    $markup[] = "<div class='{$itemOptions['class']}'>";
                }
                $markup[] = "<input type='{$this->type}' name='{$name}' value='{$val}' id='{$id}{$val}' {$attr}>";
                if ($nameOptions['has_name'] && $nameOptions['is_inside']) {
                    $markup[] = "<label for='{$id}{$val}'><img src='{$key['img']}' /><span class='{$nameOptions['class']}'>{$key['label']}</span></label>";
                } else {
                    $markup[] = "<label for='{$id}{$val}'><img src='{$key['img']}' /></label>";
                    if ($nameOptions['has_name'] && !$nameOptions['is_inside']) {
                        $markup[] = "<span class='{$nameOptions['class']}'>{$key['label']}</span>";
                    }
                }
                if ($itemOptions['has_item']) {
                    $markup[] = "</div>";
                }
            }
        }
        return join("", $markup);
    }
}
