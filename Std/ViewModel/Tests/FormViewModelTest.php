<?php

namespace Test\Std\ViewModel;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\ViewModel\FormViewModel;
use Std\HttpMessageManager\HttpMessageManager;
use Std\FormManager\Form;
use Std\FormManager\Fieldset;
use Std\FormManager\FormManager;
use Std\ViewModel\PageLayout;
use Std\ViewModel\ViewModelManager;
use Std\ViewModel\ViewModelManagerInterface;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\UploadedFile;
use Laminas\Diactoros\Uri;

/**
 * Class FormViewModelTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\ViewModel\FormViewModel
 */
class FormViewModelTest extends TestCase
{
    /**
     * @var FormViewModel $formViewModel An instance of "FormViewModel" to test.
     */
    private $formViewModel;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->formViewModel = ObjectManager::getSingleton()->create(FormViewModel::class);
    }

    /**
     * @covers \Std\ViewModel\FormViewModel::setFieldset
     * @covers \Std\ViewModel\FormViewModel::getFieldset
     */
    public function testSetGetFieldset(): void
    {
        $expected = [
            'test' => [
                'field_specification' => []
            ]
        ];
        $this->formViewModel->setFieldset($expected);
        $this->assertSame($expected, $this->formViewModel->getFieldset());
    }

    /**
     * @covers \Std\ViewModel\FormViewModel::getAction
     */
    public function testGetAction(): void
    {
        $action = $this->formViewModel->getAction();
        $this->assertSame('http:/', $action);
    }

    /**
     * @covers \Std\ViewModel\FormViewModel::init
     */
    public function testInit(): void
    {
        $expected = [
            [
                'test' => [
                    'field_specification' => []
                ]
            ]
        ];
        $this->formViewModel->init([
            'fieldset' => $expected
        ]);
        $this->formViewModel->getFieldset();
        $this->assertEquals(
            $expected,
            $this->formViewModel->getFieldset()
        );
    }

    /**
     * @covers \Std\ViewModel\FormViewModel::initForm
     * @covers \Std\ViewModel\FormViewModel::isFormInited
     */
    public function testInitForm(): void
    {
        $this->assertFalse($this->formViewModel->isFormInited());
        $expected = [
            Fieldset::class
        ];
        $this->formViewModel->init([
            'layout' => $this->createMock(PageLayout::class),
            'fieldset' => $expected
        ]);
        $this->formViewModel->triggerEvent(FormViewModel::TRIGGER_INITED);
        $this->assertTrue($this->formViewModel->isFormInited());
    }

    /**
     * @covers \Std\ViewModel\FormViewModel::setForm
     */
    public function testSetForm(): void
    {
        $expected = $this->createMock(Form::class);

        $property = (new \ReflectionClass($this->formViewModel))
            ->getProperty('form');
        $property->setAccessible(true);
        $this->formViewModel->setForm($expected);

        $this->assertSame($expected, $property->getValue($this->formViewModel));
    }

    /**
     * @covers \Std\ViewModel\FormViewModel::getForm
     */
    public function testGetForm(): void
    {
        $expected = $this->createMock(Form::class);

        $property = (new \ReflectionClass($this->formViewModel))
            ->getProperty('form');
        $property->setAccessible(true);
        $property->setValue($this->formViewModel, $expected);

        $this->assertSame($expected, $this->formViewModel->getForm());
    }

    /**
     * @covers \Std\ViewModel\FormViewModel::setFormManager
     */
    public function testSetFormManager(): void
    {
        $expected = $this->createMock(FormManager::class);

        $property = (new \ReflectionClass($this->formViewModel))
            ->getProperty('formManager');
        $property->setAccessible(true);
        $this->formViewModel->setFormManager($expected);

        $this->assertSame($expected, $property->getValue($this->formViewModel));
    }

    /**
     * @covers \Std\ViewModel\FormViewModel::getFormManager
     */
    public function testGetFormManager(): void
    {
        $expected = $this->createMock(FormManager::class);

        $property = (new \ReflectionClass($this->formViewModel))
            ->getProperty('formManager');
        $property->setAccessible(true);
        $property->setValue($this->formViewModel, $expected);

        $this->assertSame($expected, $this->formViewModel->getFormManager());
    }

    /**
     * @covers \Std\ViewModel\FormViewModel::triggerForSubmit
     * @covers \Std\ViewModel\FormViewModel::triggerForFinish
     */
    public function testTriggerForSubmit(): void
    {
        $property = (new \ReflectionClass($this->formViewModel))
            ->getProperty('finishTemplate');
        $property->setAccessible(true);
        $property->setValue($this->formViewModel, 'finishTemplate');
        $this->formViewModel->init([
            'layout' => $this->createMock(PageLayout::class),
        ]);
        $this->formViewModel->getForm()->setAttr('enctype', 'multipart/form-data');
        $psr7manager = $this->createMock(HttpMessageManager::class);
        $psr7manager->method('getRequest')->willReturn(
            $this->createServerRequestMock('POST', ['reset' => null, 'nextstatus' => 'complete'] + $this->formViewModel->getForm()->getData())
        );
        $this->formViewModel->setHttpMessageManager($psr7manager);
        $expected = (object) ['triggerFired' => false];
        $this->formViewModel->addEventListener(FormViewModel::TRIGGER_FORMSUBMIT, function () use ($expected) {
            $expected->triggerFired = true;
        });
        $this->formViewModel->triggerEvent(FormViewModel::TRIGGER_INITED);
        $this->assertTrue($expected->triggerFired);
    }

    public function testTriggerForReset(): void
    {
        $property = (new \ReflectionClass($this->formViewModel))
            ->getProperty('confirmTemplate');
        $property->setAccessible(true);
        $property->setValue($this->formViewModel, 'confirmTemplate');

        $this->formViewModel->init([
            'layout' => $this->createMock(PageLayout::class),
        ]);
        $this->formViewModel->getForm()->setAttr('enctype', 'multipart/form-data');
        $psr7manager = $this->createMock(HttpMessageManager::class);
        $psr7manager->method('getRequest')->willReturn(
            $this->createServerRequestMock('POST', $this->formViewModel->getForm()->getData())
        );
        $this->formViewModel->setHttpMessageManager($psr7manager);
        $expected = (object) ['triggerFired' => false];
        $this->formViewModel->addEventListener(FormViewModel::TRIGGER_FORMRESET, function () use ($expected) {
            $expected->triggerFired = true;
        });
        $this->formViewModel->triggerEvent(FormViewModel::TRIGGER_INITED);
        $this->assertTrue($expected->triggerFired);
    }

    /**
     * @covers \Std\ViewModel\FormViewModel::triggerForConfirm
     */
    public function testTriggerForConfirm(): void
    {
        $property = (new \ReflectionClass($this->formViewModel))
            ->getProperty('confirmTemplate');
        $property->setAccessible(true);
        $property->setValue($this->formViewModel, 'confirmTemplate');

        $this->formViewModel->init([
            'layout' => $this->createMock(PageLayout::class),
        ]);
        $this->formViewModel->getForm()->setAttr('enctype', 'multipart/form-data');
        $psr7manager = $this->createMock(HttpMessageManager::class);
        $psr7manager->method('getRequest')->willReturn(
            $this->createServerRequestMock('POST', ['reset' => null] + $this->formViewModel->getForm()->getData())
        );
        $this->formViewModel->setHttpMessageManager($psr7manager);
        $expected = (object) ['triggerFired' => false];
        $this->formViewModel->addEventListener(FormViewModel::TRIGGER_FORMCONFIRM, function () use ($expected) {
            $expected->triggerFired = true;
        });
        $this->formViewModel->triggerEvent(FormViewModel::TRIGGER_INITED);
        $this->assertTrue($expected->triggerFired);
    }

    /**
     * @covers \Std\ViewModel\FormViewModel::setMethod
     */
    public function testSetMethod(): void
    {
        $expected = "POST";

        $property = (new \ReflectionClass($this->formViewModel))
            ->getProperty('method');
        $property->setAccessible(true);
        $this->formViewModel->setMethod($expected);

        $this->assertSame($expected, $property->getValue($this->formViewModel));
    }

    /**
     * @covers \Std\ViewModel\FormViewModel::getMethod
     */
    public function testGetMethod(): void
    {
        $expected = "POST";

        $property = (new \ReflectionClass($this->formViewModel))
            ->getProperty('method');
        $property->setAccessible(true);
        $property->setValue($this->formViewModel, $expected);

        $this->assertSame($expected, $this->formViewModel->getMethod());
    }

    /**
     * copied from zend/diactoros.test
     * https://github.com/laminas/laminas-diactoros/blob/master/test/ServerRequestTest.php#L122
     *
     * @return ServerRequest
     */
    private function createServerRequestMock($method, $parsedBody)
    {
        $server = [
            'foo' => 'bar',
            'baz' => 'bat',
        ];
        $server['server'] = true;
        $files = [
            'files' => new UploadedFile('php://temp', 0, 0),
        ];
        $uri = new Uri('http://docker.local');
        $headers = [
            'host' => ['docker.local'],
        ];
        $cookies = [
            'boo' => 'foo',
        ];
        $queryParams = [
            'bar' => 'bat',
        ];
        $protocol = '1.2';
        return new ServerRequest(
            $server,
            $files,
            $uri,
            $method,
            'php://memory',
            $headers,
            $cookies,
            $queryParams,
            $parsedBody,
            $protocol
        );
    }
}
