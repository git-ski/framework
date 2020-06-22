<?php
/**
 * PHP version 7
 * File ElementTrait.php
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
use Framework\ObjectManager\ObjectManager;
use Std\FormManager\Form;
use Std\FormManager\FormManager;
use Std\FormManager\Error;

/**
 * Trait ElementTrait
 *
 * @category ElementTrait
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait ElementTrait
{
    /**
    * フォームインスタンスの参照
    * @var Form
    */
    protected $form = null;

    /**
    * 要素名
    * @var string
    */
    protected $name = null;

    /**
    * オプション
    * @var array
    */
    protected $options = [];

    /**
    * 要素タイプ
    * @var string
    */
    protected $type = null;

    /**
    * 要素値
    * @var string
    */
    protected $value = null;

    /**
    * バリデーションルールキュー
    * @var InputFilterInterface
    */
    protected $inputFilter;

    /**
    * 要素ラベル
    * @var string
    */
    public $label = null;

    /**
    * バリデーションエラーメッセージ
    * @var Error
    */
    protected $error;

    /**
    * 要素の属性
    * @var array
    */
    protected $attrs = [
        'class' => ''
    ];

    /**
    * @var string $fieldsetName
    */
    protected $fieldsetName = null;

    /**
     * Form Setter
     *
     * @param Form $form
     * @return void
     */
    public function setForm(Form $form)
    {
        return $this->form = $form;
    }

    /**
     * Form Getter
     *
     * @return Form
     */
    public function getForm() : Form
    {
        return $this->form;
    }

    /**
     * Name Setter
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Name Getter
     *
     * @return string
     */
    public function getName() : string
    {
        return (string) $this->name;
    }

    /**
     * Options Setter
     *
     * @param array $options
     * @return void
     */
    public function setOptions(array $options)
    {
        if (isset($options['label'])) {
            $this->setLabel($options['label']);
        }
        $this->options = $options;
    }

    /**
     * Options Getter
     *
     * @return array
     */
    public function getOptions() : array
    {
        return FormManager::escape($this->options);
    }

    /**
     * Type Setter
     *
     * @param string $type
     *
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Type Getter
     *
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Value Setter
     *
     * @param string|array $value
     *
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Value Getter
     *
     * @return string|array|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * FieldsetName Setter
     *
     * @param string $fieldsetName
     *
     * @return void
     */
    public function setFieldsetName($fieldsetName)
    {
        $this->fieldsetName = $fieldsetName;
    }

    /**
     * FieldsetName Getter
     *
     * @return string
     */
    public function getFieldsetName()
    {
        return $this->fieldsetName;
    }

    /**
     * Attribute Setter
     *
     * @param string  $name
     * @param  string $value
     *
     * @return void
     */
    public function setAttr($name, $value)
    {
        $this->attrs[$name] = $value;
    }

    /**
     * Attribute Getter
     *
     * @param string $name
     *
     * @return string|null
     */
    public function getAttr($name)
    {
        if (isset($this->attrs[$name])) {
            return $this->attrs[$name];
        }
    }

    public function with(array $attrs)
    {
        foreach ($attrs as $name => $value) {
            $this->setAttr($name, $value);
        }
        return $this;
    }

    public function getAttrString()
    {
        return FormManager::attrFormat(FormManager::escapeAttr($this->attrs));
    }

    /**
     * InputFilter Setter
     *
     * @param InputFilterInterface $InputFilter
     *
     * @return void
     */
    public function setInputFilter(InputFilterInterface $InputFilter)
    {
        $this->inputFilter = $InputFilter;
    }

    /**
     * InputFilter Getter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    /**
     * Label Setter
     *
     * @param string $label
     * @return void
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Label Getter
     *
     * @return string
     */
    public function getLabel() : string
    {
        return $this->label;
    }

    /**
     * Error Setter
     *
     * @param string $error
     * @return void
     */
    public function setError($error)
    {
        if ($error instanceof Error) {
            $this->error = $error;
        } else {
            $this->error = new Error();
            $this->error->setMessage($error);
        }
    }

    /**
     * Error Getter
     *
     * @return string
     */
    public function getError() : Error
    {
        if (null === $this->error) {
            $this->error = new Error();
        }
        return $this->error;
    }

    /**
     * ErrorClass Setter
     *
     * @param string $errorClass
     * @return void
     */
    public function setErrorClass($errorClass)
    {
        if (null === $this->error) {
            $this->error = new Error();
        }
        $this->error->setClass($errorClass);
    }

    /**
     * ErrorClass Getter
     *
     * @return string
     */
    public function getErrorClass() : string
    {
        if (null === $this->error) {
            $this->error = new Error();
        }
        return $this->error->getClass();
    }

    /**
     * 要素値の廃棄
     *
     * @return void
     */
    public function clear()
    {
        $this->value = null;
    }
}
