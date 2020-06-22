<?php

namespace Test\Std\FileService\Element;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\FileService\Element\File;
use Std\FileService\FileService;
use Std\FormManager\FormManager;
use Std\FormManager\Form;
use DOMDocument;

/**
 * Class FileTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\FileService\Element\File
 */
class FileTest extends TestCase
{
    /**
     * @var File $file An instance of "File" to test.
     */
    private $file;
    private $form;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->file = ObjectManager::getSingleton()->get(File::class);
        $this->form = ObjectManager::getSingleton()->get(FormManager::class)->create();
        $this->file->setForm($this->form);
    }

    /**
     * @covers \Std\FileService\Element\File::setForm
     */
    public function testSetForm(): void
    {
        $form = $this->getMockBuilder(Form::class)
                    ->disableOriginalConstructor()
                    ->getMock();
        $this->file->setForm($form);
        $this->assertSame($this->file->getForm(), $form);
    }

    /**
     * @dataProvider fileProvider
     * @covers \Std\FileService\Element\File::setValue
     */
    public function testSetValue($file): void
    {
        $this->file->setValue([
            'error' => UPLOAD_ERR_NO_FILE
        ]);
        $this->assertSame($this->file->getValue(), null);
        $this->file->setValue($file);
        $this->assertSame($this->file->getValue(), $file);
    }

    /**
     * @dataProvider fileProvider
     * @covers \Std\FileService\Element\File::isValid
     */
    public function testIsValid($file): void
    {
        $FileServiceMock = $this->getMockBuilder(FileService::class)
                                ->disableOriginalConstructor()
                                ->getMock();
        $this->file->setFileService($FileServiceMock);
        $this->file->setValue($file);
        $this->assertTrue($this->file->isValid($file));
        $this->file->setValue([
            'isValid' => true
        ]);
        $this->assertTrue($this->file->isValid([
            'isValid' => true
        ]));
        $this->file->setValue([
            'isValid' => false
        ]);
        $this->assertFalse($this->file->isValid([
            'isValid' => false
        ]));
    }

    /**
     * @covers \Std\FileService\Element\File::makeInput
     */
    public function testMakeInput(): void
    {
        $formMock = $this->getMockBuilder(Form::class)
                        ->disableOriginalConstructor()
                        ->getMock();
        $this->file->setForm($formMock);
        $input = $this->file->makeInput(null, 'class="test"');
        $node  = (array) simplexml_load_string($input);
        $this->assertEquals($node['@attributes']['type'], 'file');
        $this->assertEquals($node['@attributes']['class'], 'test');
    }

    /**
     * @covers \Std\FileService\Element\File::makeConfirm
     */
    public function testMakeConfirm(): void
    {
        $form = $this->getMockBuilder(Form::class)
                    ->disableOriginalConstructor()
                    ->getMock();
        $this->file->setForm($form);
        $input = $this->file->makeConfirm(['name' => 'test'], null);
        $node  = (array) simplexml_load_string($input);
        $this->assertEquals($node['0'], 'test');
    }

    public function fileProvider()
    {
        return [
            [
                [
                    'tmp_name' => __FILE__,
                    'size'     => 1024,
                    'error'    => 0,
                    'name'     => 'name',
                    'type'     => 'text/csv',
                ]
            ]
        ];
    }
}
