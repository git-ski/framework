<?php
/**
 * PHP version 7
 * File ElementAwareTrait.php
 *
 * @category ElementAwareTrait
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\FormManager;

use Std\FormManager\Element\FormElementInterface;
use Std\FormManager\Element\FormElementWithSessionInterface;
use Framework\ObjectManager\ObjectManager;
use InvalidArgumentException;
use Traversable;

/**
 * Trait ElementAwareTrait
 * Element アクセス用Trait
 *
 * @category Fieldset
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait ElementAwareTrait
{
    protected $elements = [];

    /**
     * Method setElements
     *
     * @param array $elements
     *
     * @return void
     */
    public function setElements(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * Method getElements
     *
     * @return array
     */
    public function getElements() : array
    {
        return $this->elements;
    }

    /**
     * Method setElement
     *
     * @param string $name
     * @param FormElementInterface $element
     *
     * @return void
     */
    public function setElement(string $name, FormElementInterface $element)
    {
        $this->elements[$name] = $element;
    }

    /**
     * Method getElement
     *
     * @param string $name
     *
     * @return FormElementInterface|void
     */
    public function getElement(string $name)
    {
        if (isset($this->elements[$name])) {
            return $this->elements[$name];
        }
    }

    /**
     * Elementを取り外す
     *
     * @param string $name
     *
     * @return FormElementInterface|void
     */
    public function removeElement(string $name)
    {
        $element = null;
        if (isset($this->elements[$name])) {
            $element = $this->elements[$name];
            unset($this->elements[$name]);
        }
        return $element;
    }

    /**
     * Elementを追加する
     *
     * @param FormElementInterface $Element
     *
     * @return void
     */
    public function appendElement(FormElementInterface $Element)
    {
        $this->setElement($Element->getElementName(), $Element);
    }

    /**
     * 要素を生成する
     *
     * @param string                $elementClass   要素クラス名
     * @param string                $name           要素ネーム
     * @param array|string|integer  $value          要素の入力値
     * @param array                 $options        要素の初期値
     *
     * @return object
     */
    public function createElement($elementClass, $name, $value = null, array $options = [])
    {
        assert(
            class_exists($elementClass),
            sprintf('要素名 %s のクラスではない文字列が渡された。Std\FormManager\Element\FormElementを継承したElementクラスを渡してください', $name)
        );
        $Element = ObjectManager::getSingleton()->create($elementClass);
        $Element->setName($name);
        if (isset($options['fieldsetName'])) {
            $Element->setFieldsetName($options['fieldsetName']);
        }
        if (isset($options['form'])) {
            $Element->setForm($options['form']);
        }
        $Element->setOptions($options);
        if ($value !== null) {
            $Element->setValue($value);
        }
        return $Element;
    }

    /**
     * from zend-form
     * Recursively populate values of attached elements and fieldsets
     *
     * @param  array|Traversable $data
     * @return void
     * @throws InvalidArgumentException
     */
    public function populateValues($data)
    {
        if (! is_array($data) && ! $data instanceof Traversable) {
            throw new InvalidArgumentException(sprintf(
                '%s expects an array or Traversable set of data; received "%s"',
                __METHOD__,
                (is_object($data) ? get_class($data) : gettype($data))
            ));
        }

        foreach ($this->getElements() as $name => $element) {
            $valueExists = array_key_exists($name, $data);

            if ($element instanceof Element\Collection) {
                if ($valueExists && null !== $data[$name]) {
                    $element->setValue($data[$name]);
                    continue;
                }

                /* This ensures that collections with allow_remove don't re-create child
                 * elements if they all were removed */
                $element->setValue([]);
                continue;
            }
            assert($element instanceof FormElementInterface);
            if ($valueExists) {
                $element->setValue($data[$name]);
            }
        }
    }

    /**
     * 要素の値を収集する
     *
     * @return array
     */
    public function collectElementValue($data = [])
    {
        foreach ($this->getElements() as $Element) {
            $name         = $Element->getName();
            $value        = $Element->getValue();
            if ($value === null) {
                continue;
            }
            $data[$name]  = $value;
        }
        return $data;
    }

    public function isValid()
    {
        $isValid = true;
        $data = $this->collectElementValue();
        foreach ($this->getElements() as $element) {
            if ($element->isValid($data) === false) {
                $isValid = false;
            }
        }
        return $isValid;
    }
}
