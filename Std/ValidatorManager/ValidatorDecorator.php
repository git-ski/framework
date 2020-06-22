<?php
/**
 * PHP version 7
 * File ValidatorDecorator.php
 *
 * @category Module
 * @package  Std\ValidatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ValidatorManager;

use Laminas\InputFilter\InputFilterInterface;
use Laminas\InputFilter\UnknownInputsCapableInterface;
use Std\TranslatorManager\TranslatorManagerAwareInterface;

/**
 * Interface ValidatorDecorator
 * @codeCoverageIgnore
 * @category Interface
 * @package  Std\ValidatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class ValidatorDecorator implements
    ValidatorInterface,
    UnknownInputsCapableInterface,
    TranslatorManagerAwareInterface
{
    use \Std\TranslatorManager\TranslatorManagerAwareTrait;

    private $messages;

    /**
     * @var InputFilterInterface|UnknownInputsCapableInterface
     */
    protected $wrapped;

    /**
     * @param InputFilterInterface|UnknownInputsCapableInterface $wrapped
     */
    public function __construct(InputFilterInterface $wrapped)
    {
        $this->wrapped = $wrapped;
    }

    /**
     * {@inheritdoc}
     */
    public function add($input, $name = null)
    {
        return $this->wrapped->add($input, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        return $this->wrapped->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        return $this->wrapped->has($name);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($name)
    {
        return $this->wrapped->remove($name);
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data)
    {
        return $this->wrapped->setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        return $this->wrapped->isValid();
    }

    /**
     * {@inheritdoc}
     */
    public function setValidationGroup($name)
    {
        return $this->wrapped->setValidationGroup($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getInvalidInput()
    {
        return $this->wrapped->getInvalidInput();
    }

    /**
     * {@inheritdoc}
     */
    public function getValidInput()
    {
        return $this->wrapped->getValidInput();
    }

    /**
     * {@inheritdoc}
     */
    public function getValue($name)
    {
        return $this->wrapped->getValue($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return $this->wrapped->getValues();
    }

    /**
     * {@inheritdoc}
     */
    public function getRawValue($name)
    {
        return $this->wrapped->getRawValue($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getRawValues()
    {
        return $this->wrapped->getRawValues();
    }

    /**
     * {@inheritdoc}
     */
    public function getMessages()
    {
        if (null === $this->messages) {
            $translator = $this->getTranslatorManager()->getTranslator(ValidatorInterface::class);
            $this->messages = $this->wrapped->getMessages();
            array_walk_recursive(
                $this->messages,
                function (&$message) use ($translator) {
                    $message = $translator->translate($message);
                }
            );
        }
        return $this->messages;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->wrapped->count();
    }

    /**
     * {@inheritdoc}
     */
    public function hasUnknown()
    {
        return $this->wrapped->hasUnknown();
    }

    /**
     * {@inheritdoc}
     */
    public function getUnknown()
    {
        return $this->wrapped->getUnknown();
    }
}
