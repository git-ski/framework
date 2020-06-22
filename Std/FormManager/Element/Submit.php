<?php
/**
 * PHP version 7
 * File Submit.php
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
 * Class Submit
 *
 * @category Submit
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Submit extends Button
{
    protected $type = 'submit';

    public function makeInput($value, $attr) : string
    {
        $name = $this->getElementName();
        return "<button type='{$this->type}' name='{$name}' value='{$value}' {$attr}>$value</button>";
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
