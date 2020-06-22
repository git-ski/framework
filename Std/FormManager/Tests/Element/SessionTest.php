<?php

namespace Test\Std\FormManager\Element;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FormManager\Element\Session;

/**
 * Class SessionTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Element\Session
 */
class SessionTest extends TestCase
{
    /**
     * @var Session $session An instance of "Session" to test.
     */
    private $session;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->session = new Session();
    }

    /**
     * @covers \Std\FormManager\Element\Session::makeInput
     */
    public function testMakeInput(): void
    {
        $this->assertEmpty(
            $this->session->makeInput('test', 'test')
        );
    }

    /**
     * @covers \Std\FormManager\Element\Session::makeConfirm
     */
    public function testMakeConfirm(): void
    {
        $this->assertEmpty(
            $this->session->makeConfirm('test', 'test')
        );
    }
}
