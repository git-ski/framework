<?php
/**
 * PHP version 7
 * File Fieldset.php
 *
 * @category Fieldset
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\FormManager;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\FormManager\Element\FormElementInterface;
use Framework\EventManager\EventTargetInterface;
use Laminas\InputFilter\InputFilterInterface;
use Std\ValidatorManager\ValidatorManagerAwareInterface;
use Std\TranslatorManager\TranslatorManagerAwareInterface;
use Std\ValidatorManager\ValidatorInterface;
use Laminas\I18n\Translator\Translator;

/**
 * Class Fieldset
 *
 * @category Fieldset
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Fieldset implements
    FieldsetInterface,
    EventTargetInterface,
    ObjectManagerAwareInterface,
    ValidatorManagerAwareInterface,
    TranslatorManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Framework\EventManager\EventTargetTrait;
    use \Std\FormManager\ElementAwareTrait;
    use \Std\FormManager\Element\ElementTrait;
    use \Std\ValidatorManager\ValidatorManagerAwareTrait;
    use \Std\TranslatorManager\TranslatorManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;

    protected $fieldset = [];

    protected $inputFilter;
    /**
     * Fieldsetセット
     *
     * @param array $fieldset
     *
     * @return void
     */
    public function setFieldset($fieldset)
    {
        if (empty($fieldset)) {
            return;
        }
        $this->fieldset = $fieldset;
    }

    /**
     * Fieldsetゲット
     *
     * @return array
     */
    public function getFieldset() : array
    {
        if (empty($this->fieldset)) {
            $this->fieldset = $this->getDefaultFieldset();
        }
        return $this->fieldset;
    }

    /**
     * Fieldset初期値設定
     *
     * @return array
     */
    public function getDefaultFieldset() : array
    {
        return [];
    }

    /**
     * Form Setter
     *
     * @param Form $form
     *
     * @return void
     */
    public function setForm(Form $form)
    {
        $this->form = $form;
    }

    /**
     * 要素 Setter
     *
     * @param string $name
     * @param FormElementInterface $element
     *
     * @return void
     */
    public function setElement(string $name, FormElementInterface $element)
    {
        $element->setFieldsetName($this->getName());
        $this->elements[$name] = $element;
    }

    /**
     * 要素追加
     *
     * @param FormElementInterface $element
     *
     * @return void
     */
    public function addElement(FormElementInterface $element)
    {
        $this->setElement($element->getName(), $element);
    }

    /**
     * Fieldset名を取得
     *
     * @return string
     */
    public function getName()
    {
        if ($this->name === null) {
            $className = explode('\\', static::class);
            $className = array_pop($className);
            $name      = str_replace('Fieldset', '', $className);
            if (empty($name)) {
                $name = 'default';
            }
            $this->name = $name;
        }
        return $this->name;
    }

    /**
     * Fieldset 初期化
     *
     * @return void
     */
    public function initialization()
    {
        $this->onInit();
        $this->triggerEvent(self::TRIGGER_INIT);
        foreach ($this->getFieldset() as $name => $field) {
            $value   = $field['value'] ?? null;
            $options = $field['options'] ?? [];
            $options['fieldsetName'] = $this->getName();
            $options['form'] = $this->getForm();
            $element = $this->createElement($field['type'], $name, $value, $options);
            $element->setName($name);
            if (isset($field['inputSpecification']) && !empty($field['inputSpecification'])) {
                $field['inputSpecification']['name'] = $name;
                $element->setInputFilter($this->getValidatorManager()->createInputFilter($field['inputSpecification']));
            }
            if (isset($field['attrs'])) {
                foreach ($field['attrs'] as $key => $val) {
                    $element->setAttr($key, $val);
                }
            }
            $this->addElement($element);
        }
        $this->triggerEvent(self::TRIGGER_INITED);
    }

    public function onInit()
    {
    }

    public function __get($name)
    {
        return $this->getElement($name);
    }

    /**
     * 要素情報を含まないフィルター及びバリデータ
     *
     * @return InputFilterInterface
     */
    public function getInputFilter() : InputFilterInterface
    {
        if (null === $this->inputFilter) {
            $inputFilters = [];
            foreach ($this->getFieldset() as $name => $field) {
                if (!empty($field['inputSpecification'])) {
                    $inputSpecification = $field['inputSpecification'];
                    $inputSpecification['name'] = $name;
                    $inputFilters[] = $inputSpecification;
                }
            }
            $this->inputFilter = $this->getValidatorManager()->createValidator($inputFilters);
        }
        return $this->inputFilter;
    }

    /**
     * Translatorを取得する
     *
     * @return Translator
     */
    public function getTranslator($type = ValidatorInterface::class) : Translator
    {
        return $this->getTranslatorManager()->getTranslator($type);
    }

    public function setName($name)
    {
        $this->name = $name;
        foreach ($this->getElements() as $element) {
            $element->setFieldsetName($name);
        }
    }

    /**
     * Make a deep clone of a fieldset
     *
     * @return void
     */
    public function __clone()
    {
        $elements = $this->getElements();
        $this->setElements([]);
        foreach ($elements as $element) {
            $this->setElement($element->getName(), clone $element);
        }
    }
}
