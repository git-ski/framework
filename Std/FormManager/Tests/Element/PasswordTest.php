<?php

namespace Test\Std\FormManager\Element;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\FormManager\Element\Password;
use Std\FormManager\Form;

/**
 * Class PasswordTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Element\Password
 */
class PasswordTest extends TestCase
{
    /**
     * @var Password $password An instance of "Password" to test.
     */
    private $password;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->password = new Password();
        $this->password->setForm(
            $this->createMock(Form::class)
        );
    }

    /**
     * @covers \Std\FormManager\Element\Password::getValue
     * @covers \Std\FormManager\Element\Password::makeInput
     * @covers \Std\FormManager\Element\Password::makeConfirm
     */
    public function testGetValue(): void
    {
        $expected = 'abcd123456';
        $this->password->setValue($expected);
        $this->assertSame(
            $expected,
            $this->password->getValue(),
        );
        $this->assertStringNotContainsString(
            $expected,
            $this->password->makeInput($expected, ''),
        );
        $this->assertStringNotContainsString(
            $expected,
            $this->password->makeConfirm($expected, ''),
        );
    }
}
