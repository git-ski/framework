<?php
/**
 * PHP version 7
 * File FieldsetAwareTrait.php
 *
 * @category Fieldset
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\FormManager;

use Std\FormManager\FieldsetInterface;
use Framework\ObjectManager\ObjectManager;

/**
 * Trait FieldsetAwareTrait
 *　Fieldsetアクセス用Trait
 *
 * @category Fieldset
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait FieldsetAwareTrait
{
    protected $fieldsets = [];

    /**
     * Method setfieldsets
     *
     * @param array $fieldsets
     *
     * @return void
     */
    public function setFieldsets(array $fieldsets)
    {
        $this->fieldsets = $fieldsets;
    }

    /**
     * Method getfieldsets
     *
     * @return array
     */
    public function getFieldsets() : array
    {
        return $this->fieldsets;
    }

    /**
     * Method setFieldset
     *
     * @param string $name
     * @param FieldsetInterface $Fieldset
     *
     * @return void
     */
    public function setFieldset(string $name, FieldsetInterface $Fieldset)
    {
        $this->fieldsets[$name] = $Fieldset;
    }

    /**
     * Method getFieldset
     *
     * @param string $name
     *
     * @return FieldsetInterface|void
     */
    public function getFieldset(string $name)
    {
        if (isset($this->fieldsets[$name])) {
            return $this->fieldsets[$name];
        }
    }

    public function hasFieldset(string $name)
    {
        return isset($this->fieldsets[$name]);
    }

    public function appendFieldset(FieldsetInterface $Fieldset)
    {
        $this->setFieldset($Fieldset->getName(), $Fieldset);
    }

    public function removeFieldset($name)
    {
        $fieldset = null;
        $name = (string) $name;
        if ($this->hasFieldset($name)) {
            $fieldset = $this->fieldsets[$name];
            unset($this->fieldsets[$name]);
        }
        return $fieldset;
    }
    /**
     * Fieldsetをフォームに追加
     *
     * @param FieldsetInterface|string $fieldsetOrClass
     *
     * @return FieldsetInterface
     */
    public function addFieldset($fieldsetOrClass, $form = null)
    {
        if (null === $form) {
            $form = $this;
        }
        $Fieldset = $fieldsetOrClass;
        if (!$fieldsetOrClass instanceof Fieldset) {
            $Fieldset = ObjectManager::getSingleton()->create($fieldsetOrClass);
        }
        assert($Fieldset instanceof FieldsetInterface);
        $Fieldset->setForm($form);
        $Fieldset->initialization();
        $this->setFieldset($Fieldset->getName(), $Fieldset);
        return $Fieldset;
    }

    public function count()
    {
        return count($this->fieldsets);
    }

    public function collectFieldsetValue($data = [])
    {
        foreach ($this->getFieldsets() as $Fieldset) {
            $name         = $Fieldset->getName();
            $value        = $Fieldset->collectElementValue();
            $data[$name]  = $value;
        }
        return $data;
    }
}
