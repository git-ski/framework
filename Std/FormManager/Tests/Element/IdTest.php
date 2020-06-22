<?php

namespace Test\Std\FormManager\Element;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FormManager\Element\Id;

/**
 * Class IdTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Element\Id
 */
class IdTest extends TestCase
{
    /**
     * @var Id $id An instance of "Id" to test.
     */
    private $id;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->id = new Id();
    }

    /**
     * @covers \Std\FormManager\Element\Id::makeInput
     */
    public function testMakeInput(): void
    {
        $this->assertEmpty(
            $this->id->makeInput('test', 'test')
        );
    }

    /**
     * @covers \Std\FormManager\Element\Id::makeConfirm
     */
    public function testMakeConfirm(): void
    {
        $this->assertEmpty(
            $this->id->makeConfirm('test', 'test')
        );
    }
}
