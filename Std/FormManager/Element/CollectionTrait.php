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

use Std\FormManager\Form;
use Std\FormManager\FormManager;
use Std\FormManager\FieldsetInterface;
use Std\FormManager\FieldsetAwareTrait;
use Std\FormManager\Fieldset;
use Std\FormManager\Element\FormElementInterface;
use DomainException;
use InvalidArgumentException;
use Framework\ObjectManager\ObjectManager;
use Traversable;
use Countable;

/**
 * Class Collection
 *
 * @category Collection
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait CollectionTrait
{
    use FieldsetAwareTrait;
    /**
     * Element used in the collection
     *
     * @var ElementInterface
     */
    protected $targetElement;

    /**
     * Initial count of target element
     *
     * @var int
     */
    protected $count = 1;

    /**
     * Are new elements allowed to be added dynamically ?
     *
     * @var bool
     */
    protected $allowAdd = true;

    /**
     * Are existing elements allowed to be removed dynamically ?
     *
     * @var bool
     */
    protected $allowRemove = true;

    /**
     * Placeholder used in template content for making your life easier with JavaScript
     *
     * @var string
     */
    protected $templatePlaceholder;

    /**
     * Element used as a template
     *
     * @var FormElementInterface|FieldsetInterface
     */
    protected $template;

    /**
     * The index of the last child element or fieldset
     *
     * @var int
     */
    protected $lastChildIndex = -1;

    /**
     * Should child elements must be created on self::prepareElement()?
     *
     * @var bool
     */
    protected $shouldCreateChildrenOnPrepareElement = true;

    protected $populated = false;

    /**
     * Accepted options for Collection:
     * - target_element: an array or element used in the collection
     * - count: number of times the element is added initially
     * - allow_add: if set to true, elements can be added to the form dynamically (using JavaScript)
     * - allow_remove: if set to true, elements can be removed to the form
     * - template_placeholder: placeholder used in the data template
     *
     * @param array|Traversable $options
     * @return Collection
     */
    public function setOptions(array $options)
    {
        parent::setOptions($options);

        if (isset($options['target_element'])) {
            $this->setTargetElement($options['target_element']);
        }

        if (isset($options['count'])) {
            $this->setCount($options['count']);
        }

        if (isset($options['allow_add'])) {
            $this->setAllowAdd($options['allow_add']);
        }

        if (isset($options['allow_remove'])) {
            $this->setAllowRemove($options['allow_remove']);
        }

        if (isset($options['template_placeholder'])) {
            $this->setTemplatePlaceholder($options['template_placeholder']);
        }
        $this->prepareElement();
        return $this;
    }

    /**
     * Populate values
     *
     * @param array|Traversable $data
     * @throws InvalidArgumentException
     * @throws DomainException
     * @return void
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

        if (! $this->allowRemove && count($data) < $this->count) {
            throw new DomainException(sprintf(
                'There are fewer elements than specified in the collection (%s). Either set the allow_remove option '
                . 'to true, or re-submit the form.',
                get_class($this)
            ));
        }

        // Check to see if elements have been replaced or removed
        $toRemove = [];
        foreach ($this->getFieldsets() as $name => $Fieldset) {
            if (isset($data[$name])) {
                continue;
            }

            if (! $this->allowRemove) {
                throw new DomainException(sprintf(
                    'Elements have been removed from the collection (%s) but the allow_remove option is not true.',
                    get_class($this)
                ));
            }

            $toRemove[] = $name;
        }

        foreach ($toRemove as $name) {
            $this->removeFieldset($name);
        }

        foreach ($data as $key => $value) {
            $key = (string) $key;
            if ($this->hasFieldset($key)) {
                $Fieldset = $this->getFieldset($key);
            } else {
                $Fieldset = $this->addNewTargetElementInstance($key);

                if ($key > $this->lastChildIndex) {
                    $this->lastChildIndex = $key;
                }
            }

            if (!$Fieldset instanceof FieldsetInterface) {
                throw new DomainException(sprintf(
                    'invalid Fieldset (%s).',
                    get_class($this)
                ));
            }
            $Fieldset->populateValues($value);
        }
        $this->populated = true;
    }

    /**
     * Set the initial count of target element
     *
     * @param $count
     * @return Collection
     */
    public function setCount($count)
    {
        $this->count = $count > 0 ? $count : 0;
        return $this;
    }

    /**
     * Get the initial count of target element
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set the target element
     *
     * @param FormElementInterface|array|Traversable $Fieldset
     * @return Collection
     * @throws InvalidArgumentException
     */
    public function setTargetElement($Fieldset)
    {
        assert($this instanceof Collection);
        if (is_array($Fieldset)) {
            $Fieldset = $this->addFieldset($Fieldset, $this->getForm());
        }

        if (! $Fieldset instanceof FieldsetInterface) {
            throw new InvalidArgumentException(sprintf(
                '%s requires that $Fieldset be an object implementing %s; received "%s"',
                __METHOD__,
                __NAMESPACE__ . '\FieldsetInterface',
                (is_object($Fieldset) ? get_class($Fieldset) : gettype($Fieldset))
            ));
        }

        $this->targetElement = $Fieldset;

        return $this;
    }

    /**
     * Get target element
     *
     * @return FormElementInterface|FieldsetInterface
     */
    public function getTargetElement()
    {
        return $this->targetElement;
    }

    /**
     * Get allow add
     *
     * @param bool $allowAdd
     * @return Collection
     */
    public function setAllowAdd($allowAdd)
    {
        $this->allowAdd = (bool) $allowAdd;
        return $this;
    }

    /**
     * Get allow add
     *
     * @return bool
     */
    public function allowAdd()
    {
        return $this->allowAdd;
    }

    /**
     * @param bool $allowRemove
     * @return Collection
     */
    public function setAllowRemove($allowRemove)
    {
        $this->allowRemove = (bool) $allowRemove;
        return $this;
    }

    /**
     * @return bool
     */
    public function allowRemove()
    {
        return $this->allowRemove;
    }

    /**
     * Set the placeholder used in the template generated to help create new elements in JavaScript
     *
     * @param string $templatePlaceholder
     * @return Collection
     */
    public function setTemplatePlaceholder($templatePlaceholder)
    {
        if (is_string($templatePlaceholder)) {
            $this->templatePlaceholder = $templatePlaceholder;
        }

        return $this;
    }

    /**
     * Get the template placeholder
     *
     * @return string
     */
    public function getTemplatePlaceholder()
    {
        if (null === $this->templatePlaceholder) {
            $this->templatePlaceholder = self::DEFAULT_TEMPLATE_PLACEHOLDER;
        }
        return $this->templatePlaceholder;
    }

    /**
     * Get a template element used for rendering purposes only
     *
     * @return null|ElementInterface|FieldsetInterface
     */
    public function getTemplate()
    {
        if ($this->template === null) {
            $this->template = $this->createTemplateFieldset();
        }

        return $this->template;
    }

    /**
     * Create a new instance of the target element
     *
     * @return FormElementInterface
     */
    public function createNewTargetElementInstance()
    {
        return clone $this->getTargetElement();
    }

    /**
     * Add a new instance of the target element
     *
     * @param string $name
     * @return FormElementInterface
     * @throws DomainException
     */
    protected function addNewTargetElementInstance($name)
    {
        assert($this instanceof Collection);
        $name = (string) $name;
        $FieldsetName = $this->getElementName() . '[' . $name . ']';
        $this->shouldCreateChildrenOnPrepareElement = false;

        $Fieldset = $this->createNewTargetElementInstance();
        $Fieldset->setName($FieldsetName);

        $this->setFieldset($name, $Fieldset);

        if (! $this->allowAdd && $this->count() > $this->count) {
            throw new DomainException(sprintf(
                'There are more elements than specified in the collection (%s). Either set the allow_add option ' .
                'to true, or re-submit the form.',
                get_class($this)
            ));
        }

        return $Fieldset;
    }

    /**
     * Create a dummy template element
     *
     * @return null|ElementInterface|FieldsetInterface
     */
    protected function createTemplateFieldset()
    {
        if ($this->template) {
            return $this->template;
        }

        $Fieldset = $this->createNewTargetElementInstance();

        assert($this instanceof FormElementInterface);

        if ($this->templatePlaceholder) {
            $name = (string) $this->templatePlaceholder;
            $FieldsetName = $this->getElementName() . '[' . $name . ']';
        } else {
            $FieldsetName = $this->getElementName();
        }

        $Fieldset->setName($FieldsetName);

        return $Fieldset;
    }

    /**
     * Fieldsetをフォームに追加
     *
     * @param FieldsetInterface|string $fieldsetOrClass
     *
     * @return FieldsetInterface
     */
    public function addFieldset(array $fieldset, $form)
    {
        if (isset($fieldset['type'])) {
            ['type' => $fieldsetOrClass] = $fieldset;
            $Fieldset = $fieldsetOrClass;
            if (!$fieldsetOrClass instanceof Fieldset) {
                $Fieldset = ObjectManager::getSingleton()->create($fieldsetOrClass);
            }
            assert($Fieldset instanceof FieldsetInterface);
        } else {
            $Fieldset = ObjectManager::getSingleton()->create(Fieldset::class);
            $Fieldset->setFieldset($fieldset);
        }
        $Fieldset->setForm($form);
        $Fieldset->initialization();
        return $Fieldset;
    }

    /**
     * Prepare the collection by adding a dummy template element if the user want one
     *
     * @param  FormInterface $form
     * @return mixed|void
     */
    public function prepareElement()
    {
        if (true === $this->shouldCreateChildrenOnPrepareElement) {
            if ($this->targetElement !== null && $this->count > 0) {
                while ($this->count > $this->lastChildIndex + 1) {
                    $this->addNewTargetElementInstance(++$this->lastChildIndex);
                }
            }
        }
    }
}
