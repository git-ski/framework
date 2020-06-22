<?php

namespace Test\Std\ViewModel;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\ViewModel\SubFormViewModel;
use Std\ViewModel\FormViewModel;
use Std\FormManager\Form;

/**
 * Class SubFormViewModelTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\ViewModel\SubFormViewModel
 */
class SubFormViewModelTest extends TestCase
{
    /**
     * @var SubFormViewModel $subFormViewModel An instance of "SubFormViewModel" to test.
     */
    private $subFormViewModel;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->subFormViewModel = ObjectManager::getSingleton()->create(SubFormViewModel::class);
    }

    /**
     * @covers \Std\ViewModel\SubFormViewModel::setFieldset
     * @covers \Std\ViewModel\SubFormViewModel::getFieldset
     * @covers \Std\ViewModel\SubFormViewModel::isFormInited
     * @covers \Std\ViewModel\SubFormViewModel::setForm
     * @covers \Std\ViewModel\SubFormViewModel::getForm
     */
    public function testSetGetForm(): void
    {
        $expected = [
            'test' => [
                'field_specification' => []
            ]
        ];
        $this->subFormViewModel->setFieldset($expected);
        $this->assertSame($expected, $this->subFormViewModel->getFieldset());
        $this->assertFalse(
            $this->subFormViewModel->isFormInited()
        );
        $expected = $this->createMock(Form::class);
        $this->subFormViewModel->setForm($expected);
        $this->assertSame(
            $expected,
            $this->subFormViewModel->getForm()
        );
    }

    /**
     * @covers \Std\ViewModel\SubFormViewModel::setExportView
     * @covers \Std\ViewModel\SubFormViewModel::proxyExportFormEvent
     */
    public function testSetExportView(): void
    {
        $expected = $this->createMock(FormViewModel::class);
        $this->subFormViewModel->setExportView($expected);
        $this->assertSame(
            $expected,
            $this->subFormViewModel->getExportView()
        );
    }

    /**
     * @covers \Std\ViewModel\SubFormViewModel::setExportView
     * @covers \Std\ViewModel\SubFormViewModel::proxyExportFormEvent
     */
    public function testSetExportView2(): void
    {
        $expected = $this->createMock(FormViewModel::class);
        $expected->method('isFormInited')->willReturn(true);
        $this->subFormViewModel->setExportView($expected);
        $this->assertSame(
            $expected,
            $this->subFormViewModel->getExportView()
        );
    }
}
