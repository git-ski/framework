<?php

namespace Test\Std\TranslatorManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\TranslatorManager\TranslatorManager;
use Laminas\I18n\Translator\Translator;

/**
 * Class TranslatorManagerTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\TranslatorManager\TranslatorManager
 */
class TranslatorManagerTest extends TestCase
{
    /**
     * @var TranslatorManager $translatorManager An instance of "TranslatorManager" to test.
     */
    private $translatorManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->translatorManager = ObjectManager::getSingleton()->create(TranslatorManager::class);
    }

    /**
     * @covers \Std\TranslatorManager\TranslatorManager::getTranslator
     * @covers \Std\TranslatorManager\TranslatorManager::createTranslator
     */
    public function testGetTranslator(): void
    {
        $this->assertTrue(
            $this->translatorManager->getTranslator(__CLASS__) instanceof Translator
        );
    }

    /**
     * @covers \Std\TranslatorManager\TranslatorManager::getTranslators
     */
    public function testSetGetTranslators(): void
    {
        $expected = new Translator();
        $this->translatorManager->setTranslator(__CLASS__, $expected);
        $this->assertSame(
            $expected,
            $this->translatorManager->getTranslator(__CLASS__)
        );
        $this->assertContains(
            $expected,
            $this->translatorManager->getTranslators()
        );
        $this->translatorManager->setLocale('en');
        $this->assertEquals('en', $expected->getLocale());
    }
}
