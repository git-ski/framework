<?php

namespace Test\Std\FormManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\FormManager\Form;
use Std\FormManager\FormManager;

/**
 * Class FormTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FormManager\Form
 */
class Form2Test extends TestCase
{
    /**
     * @var Form $form An instance of "Form" to test.
     */
    private $form;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->form = ObjectManager::getSingleton()->create(FormManager::class)->create();
    }

    /**
     * @covers \Std\FormManager\Form::setId
     */
    public function testSetId(): void
    {
        $expected = "formId";

        $property = (new \ReflectionClass($this->form))
            ->getProperty('id');
        $property->setAccessible(true);
        $this->form->setId($expected);

        $this->assertSame($expected, $property->getValue($this->form));
    }

    /**
     * @covers \Std\FormManager\Form::getId
     */
    public function testGetId(): void
    {
        $expected = "formId";

        $property = (new \ReflectionClass($this->form))
            ->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($this->form, $expected);

        $this->assertSame($expected, $this->form->getId());
    }

    /**
     * @covers \Std\FormManager\Form::getUniqid
     */
    public function testGetUniqid(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->form))
            ->getProperty('uniqid');
        $property->setAccessible(true);
        $property->setValue($this->form, $expected);

        $this->assertSame($expected, $this->form->getUniqid());
    }

    /**
     * @covers \Std\FormManager\Form::setMessage
     */
    public function testSetGetMessage(): void
    {
        $expected = [
            'messages' => [
                'nestMessage',
            ],
            'message2' => 'message'
        ];
        $this->form->setMessage($expected);

        $this->assertSame($expected, $this->form->getMessage());
    }

    /**
     * @covers \Std\FormManager\Form::setAttr
     */
    public function testSetGetAttr(): void
    {
        $expected = 'testForm';
        $this->form->setAttr('class', $expected);
        $this->assertEquals(
            $expected,
            $this->form->getAttr('class')
        );
    }

    /**
     * @covers \Std\FormManager\Form::getData
     */
    public function testSetGetData(): void
    {
        $expected = 'value';
        // フォーム自体は、メタ情報を保つため、不完全なデータから保護するため
        // メタ情報と一致しないデータを受け付けない。
        $this->form->setData([
            'top' => [
                'nest' => $expected
            ]
        ]);
        $this->assertNotSame($expected, $this->form->getData('top', 'nest'));
    }

    /**
     * @covers \Std\FormManager\Form::match
     */
    public function testMatch(): void
    {
        // メタ情報チェック
        $this->assertFalse(
            $this->form->match([
                Form::ELEMENT_ID => 'whatever',
                'no_meta_data' => []
            ])
        );
        $this->assertTrue(
            $this->form->match([
                'has_meta_data' => []
            ] + $this->form->getData())
        );
    }

    /**
     * @covers \Std\FormManager\Form::forceError
     */
    public function testForceError(): void
    {
        $this->assertTrue(
            $this->form->isValid()
        );
        $this->form->forceError();
        $this->assertFalse(
            $this->form->isValid()
        );
    }
}
