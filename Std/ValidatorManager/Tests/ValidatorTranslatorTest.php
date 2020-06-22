<?php

namespace Test\Std\ValidatorManager;

use Framework\ObjectManager\ObjectManager;
use PHPUnit\Framework\TestCase;
use Std\ValidatorManager\ValidatorTranslator;
use Laminas\I18n\Translator\Translator;

/**
 * Class ValidatorTranslatorTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\ValidatorManager\ValidatorTranslator
 */
class ValidatorTranslatorTest extends TestCase
{
    /**
     * @var ValidatorTranslator $validatorTranslator An instance of "ValidatorTranslator" to test.
     */
    private $validatorTranslator;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->validatorTranslator = new ValidatorTranslator(new Translator());
    }

    /**
     * @covers \Std\ValidatorManager\ValidatorTranslator::__construct
     */
    public function testConstruct(): void
    {
        $property = (new \ReflectionClass($this->validatorTranslator))
            ->getProperty('translator');
        $property->setAccessible(true);
        $Translator = $property->getValue($this->validatorTranslator);
        $this->assertTrue($Translator instanceof Translator);
    }

    /**
     * @covers \Std\ValidatorManager\ValidatorTranslator::translate
     */
    public function testTranslate(): void
    {
        $message = $this->validatorTranslator->translate(__CLASS__);
        $this->assertSame(__CLASS__, $message);
    }
}
