<?php
/**
 * PHP version 7
 * File Collection.php
 *
 * @category FormElement
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\FormManager\Element;

use LogicException;
use Std\FormManager\FieldsetInterface;
use Framework\ObjectManager\ObjectManager;
use Countable;
use ArrayIterator;

/**
 * Class Collection
 *
 * @category Collection
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Collection extends FormElement implements
    FormElementWithSessionInterface,
    Countable
{
    use CollectionTrait;

    /**
     * Default template placeholder
     */
    const DEFAULT_TEMPLATE_PLACEHOLDER = '';

    protected $type = 'text';

    public function isValid($data)
    {
        $isValid = parent::isValid($data);
        $name = $this->getName();
        $data = $data[$name] ?? [];
        foreach ($this->getFieldsets() as $index => $Fieldset) {
            $values = $data[$index] ?? [];
            foreach ($Fieldset->getElements() as $element) {
                if ($element->isValid($values) === false) {
                    $this->getForm()->addMessage($element->getElementName(), $element->error);
                    $isValid = false;
                }
            }
        }
        return $isValid;
    }

    public function setValue($value)
    {
        $value = $value ?? [];
        $this->populateValues($value);
    }

    public function getValue()
    {
        if ($this->populated) {
            $values = [];
            foreach ($this->getFieldsets() as $name => $Fieldset) {
                $data = $Fieldset->collectElementValue();
                if ($data) {
                    $values[$name] = $data;
                }
            }
            return empty($values) ? null : $values;
        }
    }

    public function setFieldsetName($fieldsetName)
    {
        $this->fieldsetName = $fieldsetName;
        $CollectionName = $this->getElementName();
        if ($this->getTargetElement()) {
            $targetFieldsetName = $this->getTargetElement()->getFieldsetName();
            if ($targetFieldsetName !== $CollectionName) {
                $this->getTargetElement()->setFieldsetName($CollectionName);
                foreach ($this->getFieldsets() as $name => $Fieldset) {
                    $FieldsetName = $CollectionName . '[' . $name . ']';
                    $Fieldset->setName($FieldsetName);
                }
            }
        }
    }

    /**
     * 要素値の廃棄
     *
     * @return void
     */
    public function clear()
    {
        foreach ($this->getFieldsets() as $Fieldset) {
            foreach ($Fieldset->getElements() as $Element) {
                $Element->clear();
            }
        }
    }

    public function removeInputFilter() : FormElementInterface
    {
        $targetElement = $this->getTargetElement();
        assert($targetElement instanceof FieldsetInterface);
        foreach ($targetElement->getElements() as $Element) {
            $Element->removeInputFilter();
        }
        foreach ($this->getFieldsets() as $Fieldset) {
            foreach ($Fieldset->getElements() as $Element) {
                $Element->removeInputFilter();
            }
        }
        return parent::removeInputFilter();
    }

    /**
     * @inheritDoc
     */
    public function makeInput($value, $attr) : string
    {
        throw new LogicException('Collectionは直接出力不可');
    }

    /**
     * @inheritDoc
     */
    public function makeConfirm($value, $attr) : string
    {
        throw new LogicException('Collectionは直接出力不可');
    }

    public function iterate()
    {
        return new ArrayIterator($this->getFieldsets());
    }

    public function __toString()
    {
        return $this->getElementName();
    }

    public function __clone()
    {
        $this->setTargetElement(clone $this->getTargetElement());
        $Fieldsets = $this->getFieldsets();
        foreach ($Fieldsets as $name => $Fieldset) {
            $Fieldsets[$name] = clone $Fieldset;
        }
        $this->setFieldsets($Fieldsets);
    }

    public function getId()
    {
        return spl_object_hash($this);
    }
}
