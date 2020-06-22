<?php
/**
 * PHP version 7
 * File Hidden.php
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
 * Class Hidden
 *
 * @category Hidden
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Hidden extends FormElement
{
    protected $type = 'hidden';

    /**
     * Input要素の生成
     *
     * @param string $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeInput($value, $attr) : string
    {
        $name = $this->getElementName();
        return "<input type='{$this->type}' name='{$name}' value='{$value}' {$attr} />";
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
        return $this->makeInput($value, $attr);
    }
}
