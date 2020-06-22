<?php
/**
 * PHP version 7
 * File Reset.php
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
 * Class Reset
 *
 * @category Reset
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Reset extends Submit
{
    protected $type = 'reset';

    public function makeInput($value, $attr) : string
    {
        $name = $this->getElementName();
        $label = $value;
        if ($this->type === 'reset') {
            $value = '';
        }
        return "<button type='{$this->type}' name='{$name}' value='{$value}' {$attr}>$label</button>";
    }

    /**
     * 確認用要素の生成
     *
     * @param string $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeConfirm($value, $attr) : string
    {
        return $this->makeInput($value, $attr);
    }
}
