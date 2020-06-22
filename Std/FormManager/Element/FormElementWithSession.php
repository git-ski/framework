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

use Std\SessionManager\SessionManagerAwareInterface;
use Std\FormManager\Form;

/**
 * Class FormElement
 *
 * @category FormElement
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
abstract class FormElementWithSession extends FormElement implements
    FormElementWithSessionInterface,
    SessionManagerAwareInterface
{
    use \Std\SessionManager\SessionManagerAwareTrait;

    /**
     * Value Setter
     *
     * @param string|array $value
     *
     * @return void
     */
    public function setValue($value)
    {
        if ($this->getSessionName()) {
            $Session = $this->getForm()->getSession();
            $name = $this->getElementName();
            $Session[$name] = $value;
        }
        parent::setValue($value);
    }

    /**
     * Value Getter
     *
     * @return string|array|null
     */
    public function getValue()
    {
        if ($this->getSessionName()) {
            $Session = $this->getForm()->getSession();
            $name = $this->getElementName();
            return $Session[$name];
        }
        return parent::getValue();
    }

    public function setForm(Form $form)
    {
        parent::setForm($form);
        $this->setValue($this->getValue());
    }

    /**
     * 要素値の廃棄
     *
     * @return void
     */
    public function clear()
    {
        $Session = $this->getForm()->getSession();
        $name = $this->getElementName();
        unset($Session[$name]);
    }

    private function getSessionName()
    {
        if ($this->getForm()) {
            return $this->getForm()->getUniqid();
        }
    }
}
