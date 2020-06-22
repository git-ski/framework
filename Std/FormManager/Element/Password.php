<?php
/**
 * PHP version 7
 * File Password.php
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
 * Class Password
 *
 * @category Password
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Password extends FormElementWithSession
{

    protected $type = 'password';

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        $value = parent::getValue();
        if (empty($value) && $value !== '0') {
            $value = null;
        }
        return $value;
    }

    /**
     * パスワードはいかなる場合でも、値を表示することを禁じます。
     *
     * @param array $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeInput($value, $attr) : string
    {
        $name = $this->getElementName();
        return "<input type='{$this->type}' name='{$name}' value='' {$attr} />";
    }

    /**
     * パスワードはいかなる場合でも、値を表示することを禁じます。
     *
     * @param array  $value 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    public function makeConfirm($value, $attr) : string
    {
        $value = (string) $value;
        // パスワードの推測を防ぐため、固定20文字のアスタでマスキングする
        return "<label class='form_label form_{$this->type}'>*******************</label>";
    }
}
