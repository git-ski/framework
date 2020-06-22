<?php
/**
 * PHP version 7
 * File FormElementInterface.php
 *
 * @category FormElement
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\FormManager\Element;

use Laminas\InputFilter\InputFilterInterface;
use Std\FormManager\Form;
use Std\Renderer\SafeInterface;
use Std\FormManager\Error;

/**
 * Interface FormElementInterface
 *
 * @category FormElementInterface
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface FormElementInterface extends SafeInterface
{
    /**
     * Form Setter
     *
     * @param Form $form
     * @return void
     */
    public function setForm(Form $form);

    /**
     * Form Getter
     *
     * @return Form
     */
    public function getForm() : Form;

    /**
     * Name Setter
     *
     * @param string $name
     * @return void
     */
    public function setName($name);

    /**
     * Name Getter
     *
     * @return string
     */
    public function getName() : string;

    /**
     * フォーム内の要素名を取得
     * Fieldsetに所属する際は、Fieldset名も連れる
     *
     * @return string
     */
    public function getElementName();

    /**
     * Options Setter
     *
     * @param array $options
     * @return void
     */
    public function setOptions(array $options);

    /**
     * Options Getter
     *
     * @return array
     */
    public function getOptions() : array;

    /**
     * Type Setter
     *
     * @param string $type
     *
     * @return void
     */
    public function setType($type);

    /**
     * Type Getter
     *
     * @return string
     */
    public function getType() : string;

    /**
     * Value Setter
     *
     * @param string|array $value
     *
     * @return void
     */
    public function setValue($value);

    /**
     * Value Getter
     *
     * @return string|array|null
     */
    public function getValue();

    /**
     * FieldsetName Setter
     *
     * @param string $fieldsetName
     *
     * @return void
     */
    public function setFieldsetName($fieldsetName);

    /**
     * FieldsetName Getter
     *
     * @return string
     */
    public function getFieldsetName();

    /**
     * Attribute Setter
     *
     * @param string  $name
     * @param  string $value
     *
     * @return void
     */
    public function setAttr($name, $value);

    /**
     * Attribute Getter
     *
     * @param string $name
     *
     * @return string|null
     */
    public function getAttr($name);

    /**
     * InputFilter Setter
     *
     * @param InputFilterInterface $InputFilter
     *
     * @return void
     */
    public function setInputFilter(InputFilterInterface $InputFilter);

    /**
     * InputFilter取得
     *
     * @return InputFilterInterface
     */
    public function getInputFilter();

    /**
     * 要素のInputFilterを解除する
     *
     * @return $this
     */
    public function removeInputFilter() : FormElementInterface;

    /**
     * error Setter
     *
     * @param string $error
     *
     * @return void
     */
    public function setError($error);

    /**
     * error Getter
     *
     * @return string
     */
    public function getError() : Error;

    /**
     * 要素のclass追加
     *
     * @param string $class class名
     *
     * @return $this
     */
    public function addClass($class) : FormElementInterface;

    /**
     * 要素のclass削除
     *
     * @param string $class class名
     *
     * @return $this
     */
    public function removeClass($class) : FormElementInterface;

    /**
     * 要素値の廃棄
     *
     * @return void
     */
    public function clear();

    /**
     * バリデーション処理
     *
     * @return boolean
     */
    public function isValid($data);

    /**
     * Input要素の生成
     *
     * @param array  $value 入力データ
     * @param string $attr  要素の属性
     *
     * @return string
     */
    public function makeInput($value, $attr) : string;

    /**
     * 確認用要素の生成
     *
     * @param array  $value 入力データ
     * @param string $attr  要素の属性
     *
     * @return string
     */
    public function makeConfirm($value, $attr) : string;
}
