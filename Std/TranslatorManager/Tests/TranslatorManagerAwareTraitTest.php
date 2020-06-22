<?php

namespace Test\Std\TranslatorManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\TranslatorManager\TranslatorManagerAwareTrait;
use Std\TranslatorManager\TranslatorManagerInterface;

/**
 * Class TranslatorManagerAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\TranslatorManager\TranslatorManagerAwareTrait
 */
class TranslatorManagerAwareTraitTest extends TestCase
{
    /**
     * @var TranslatorManagerAwareTrait $translatorManagerAwareTrait An instance of "TranslatorManagerAwareTrait" to test.
     */
    private $translatorManagerAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->translatorManagerAwareTrait = $this->getMockBuilder(TranslatorManagerAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\TranslatorManager\TranslatorManagerAwareTrait::setTranslatorManager
     */
    public function testSetGetTranslatorManager(): void
    {
        $expected = $this->createMock(TranslatorManagerInterface::class);
        $this->translatorManagerAwareTrait->setTranslatorManager($expected);
        $this->assertSame(
            $expected,
            $this->translatorManagerAwareTrait->getTranslatorManager()
        );
    }
}
