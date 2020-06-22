<?php

namespace Test\Std\FormManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\FormManager\Fieldset;
use Std\FormManager\Form;
use Std\FormManager\Element\FormElementInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\I18n\Translator\Translator;

/**
 * Class FieldsetTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Fieldset
 */
class FieldsetTest extends TestCase
{
    /**
     * @var Fieldset $fieldset An instance of "Fieldset" to test.
     */
    private $fieldset;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->fieldset = ObjectManager::getSingleton()->create(Fieldset::class);
    }

    /**
     * @covers \Std\FormManager\Fieldset::setFieldset
     */
    public function testSetFieldset(): void
    {
        $this->fieldset->setFieldset(null);
        $this->assertSame(
            [],
            $this->fieldset->getFieldset()
        );
    }

    /**
     * @covers \Std\FormManager\Fieldset::getTranslator
     */
    public function testGetTranslator(): void
    {
        $this->assertTrue(
            $this->fieldset->getTranslator() instanceof Translator
        );
    }
}
