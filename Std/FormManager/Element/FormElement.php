<?php
/**
 * PHP version 7
 * File FormElement.php
 *
 * @category FormElement
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\FormManager\Element;

use Laminas\InputFilter\InputFilter;
use Std\FormManager\FormManager;
use Std\TranslatorManager\TranslatorManagerAwareInterface;
use Std\ValidatorManager\ValidatorInterface;
use Std\EntityManager\EntityInterface;
use LogicException;

/**
 * Class FormElement
 *
 * @category FormElement
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
abstract class FormElement implements
    FormElementInterface,
    TranslatorManagerAwareInterface
{
    use \Std\TranslatorManager\TranslatorManagerAwareTrait;
    use \Std\FormManager\Element\ElementTrait;

    public $isValid = null;

    /**
     * 要素にclassを追加
     *
     * @param string $class
     *
     * @return $this
     */
    public function addClass($class) : FormElementInterface
    {
        $cls = explode(' ', $this->getAttr('class'));
        if (!in_array($class, $cls)) {
            $cls[] = $class;
        }
        $cls = join(' ', $cls);
        $this->setAttr('class', $cls);
        return $this;
    }

    /**
     * 要素にclassを削除
     *
     * @param string $class
     *
     * @return $this
     */
    public function removeClass($class) : FormElementInterface
    {
        $cls = explode(' ', $this->getAttr('class'));
        if (in_array($class, $cls)) {
            $cls = array_diff($cls, array($class));
        }
        $cls = join(' ', $cls);
        $this->setAttr('class', $cls);
        return $this;
    }

    /**
     * 要素のInputFilterを解除する
     *
     * @return $this
     */
    public function removeInputFilter() : FormElementInterface
    {
        $this->inputFilter = null;
        return $this;
    }

    /**
     * フォーム内の要素名を取得
     * Fieldsetに所属する際は、Fieldset名も連れる
     *
     * @return string
     */
    public function getElementName()
    {
        if ($this->getFieldsetName()) {
            $elementName = $this->getFieldsetName() . '[' . $this->getName() . ']';
        } else {
            $elementName = $this->getName();
        }
        return $elementName;
    }

    /**
     * バリデーション処理
     *
     * @return boolean
     */
    public function isValid($data)
    {
        if (null === $this->isValid) {
            $inputFilter = $this->getInputFilter();
            if (!$inputFilter) {
                return $this->isValid = true;
            }
            assert($inputFilter instanceof InputFilter);
            $inputFilter->setData($data);
            $this->isValid = $inputFilter->isValid();
            $name = $this->getName();
            if (!$this->isValid) {
                $translator = $this->getTranslatorManager()->getTranslator(ValidatorInterface::class);
                $errors     = [];
                $messages   = (array) $inputFilter->getMessages()[$name];
                array_walk_recursive(
                    $messages,
                    function ($message) use (&$errors, $translator) {
                        $errors[] = FormManager::escape($translator->translate($message));
                    }
                );
                $errors      = nl2br(join(PHP_EOL, $errors));
                $this->setError($errors);
                $this->getForm()->addMessage($this->getElementName(), $errors);
            }
            $this->setValue($inputFilter->getValue($name));
        }
        return $this->isValid;
    }

    public function resetValid()
    {
        $this->isValid = null;
    }

    public function isRequired()
    {
        if (!$this->getInputFilter()) {
            return false;
        }
        $name = $this->getName();
        $input = $this->getInputFilter()->get($name);
        return $input ? $input->isRequired() : false;
    }

    /**
     * 要素を表示
     * フォーム要素はEntityInterfaceのオブジェクトを直接扱わない・扱えない。
     * 渡された値がEntityInterfaceの場合、外部ロジックが変換を欠落していることに想定される
     * ここに来てた場合は、LogicExceptionを投げる。
     *
     * @return string
     * @throws LogicException
     */
    public function toString()
    {
        $value = $this->getValue();
        if ($value instanceof EntityInterface) {
            throw new LogicException(
                sprintf(
                    '無効な値がフォームにセットされている、%s に Entity : %s がセットされている。ViewModel/Model側で変換処理が欠落されているか確認ください',
                    $this->getElementName(),
                    get_class($value)
                )
            );
        }
        $value = FormManager::escape($value);
        $attrs = $this->getAttrString();
        if ($this->getForm()->isConfirmed()) {
            $result = $this->makeConfirm($value, $attrs);
        } else {
            $result = $this->makeInput($value, $attrs);
        }
        return $result;
    }

    /**
     * 後方互換
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Input要素の生成
     *
     * @param array|string  $input 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    abstract public function makeInput($input, $attr) : string;

    /**
     * 確認用要素の生成
     *
     * @param array|string  $input 入力データ
     * @param string $attr  要素の属性
     * @return string
     */
    abstract public function makeConfirm($input, $attr) : string;
}
