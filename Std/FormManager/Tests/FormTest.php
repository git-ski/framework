<?php
/**
 * PHP version 7
 * File TestCase.php
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\FormManager\Tests;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\FormManager\FormManager;
use Std\FormManager\Form;
use Std\FormManager\FieldsetInterface;
use Std\FormManager\Element\FormElementInterface;
use Std\FormManager\Tests\Stub\TestFieldset;
use Std\FormManager\Tests\Stub\TestCollectionFieldset;
use Std\FormManager\Tests\Stub\TestCollectionFieldset2;
use Std\FormManager\Tests\Stub\InvalidCollectionFieldset;
use Std\FormManager\Tests\Stub\InvalidCollectionFieldset2;
use Std\FormManager\Tests\Stub\TestElementFieldset;
use Laminas\InputFilter\InputFilterInterface;

/**
 * Class TestCase
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class FormTest extends TestCase
{
    /**
    * setUpBeforeClass
    *
    * @api
    * @access
    * @return  null
    * @example
    * @since
    */
    public static function setUpBeforeClass() : void
    {
    }

    /**
    * tearDownAfterClass
    *
    * @api
    * @access
    * @return  null
    * @example
    * @since
    */
    public static function tearDownAfterClass() : void
    {
    }

    /**
     *
     */
    public function testFormConstructor()
    {
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create();
        $this->assertInstanceof(FormElementInterface::class, $form->form_id);
        $this->assertInstanceof(FormElementInterface::class, $form->csrf);
        $this->assertInstanceof(FormElementInterface::class, $form->nextstatus);
        ob_start();
        $form->start();
        $start = ob_get_clean();
        ob_start();
        $form->end();
        $end = ob_get_clean();
        $this->assertStringContainsString('<form', $start);
        $this->assertStringContainsString('</form', $end);
    }

    /**
     */
    public function testFormConstructorError1()
    {
        $this->expectException(\ErrorException::class);
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form = $FormManager->create(__FUNCTION__);
    }

    /**
     */
    public function testFormConstructorError2()
    {
        $this->expectException(\ErrorException::class);
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->find();
        $form = $FormManager->find(__FUNCTION__);
    }

    /**
     *
     */
    public function testFormCollectionEmptySubmit()
    {
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form->addFieldset(TestCollectionFieldset::class);
        $TestCollection = $form->test->collection;
        $this->assertCount(1, $form->getFieldsets());
        $this->assertCount(5, $TestCollection);
        $this->assertEquals(5, $TestCollection->getCount());
        $this->assertInstanceof(FieldsetInterface::class, $TestCollection->getTemplate());
        $form->submit();
        $this->assertFalse($form->isValid());
        $this->assertFalse($form->isSubmited());
        $this->assertFalse($form->isConfirmed());
        $this->assertFalse($form->isFinish());
    }

    /**
     *
     */
    public function testFormCollectionWithoutValidate()
    {
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form->addFieldset(TestCollectionFieldset::class);
        $TestCollection = $form->test->collection;
        $this->assertCount(1, $form->getFieldsets());
        $this->assertCount(5, $TestCollection);
        $this->assertEquals(5, $TestCollection->getCount());
        $this->assertInstanceof(FieldsetInterface::class, $TestCollection->getTemplate());
        $TestCollection->removeInputFilter();
        $form->submit();
        $this->assertTrue($form->isValid());
        $this->assertTrue($form->isSubmited());
        $this->assertTrue($form->isConfirmed());
        $this->assertFalse($form->isFinish());
    }

    /**
     *
     */
    public function testFormCollection()
    {
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form->addFieldset(TestCollectionFieldset::class);
        $TestCollection = $form->test->collection;
        $this->assertCount(1, $form->getFieldsets());
        $this->assertCount(5, $TestCollection);
        $this->assertEquals(5, $TestCollection->getCount());
        $this->assertInstanceof(FieldsetInterface::class, $TestCollection->getTemplate());
        // データをセットして、そしてsubmit
        $formMeta = $form->getData();
        $inputData = [
            'collection' => [
                ['test' => 'test1'],
                ['test' => 'test2']
            ]
        ];
        $formMeta['test'] = $inputData;
        $form->setData($formMeta);
        $this->assertCount(1, $form->getFieldsets());
        $this->assertCount(2, $TestCollection);
        $this->assertInstanceof(FieldsetInterface::class, $TestCollection->getTemplate());
        $ChildFieldset = $TestCollection->getFieldsets()[0];
        $this->assertEquals("<input type='text' name='test[collection][0][test]' value='test1' class='test'>", (string) $ChildFieldset->test);
        $form->submit();
        $this->assertTrue($form->isValid());
        $this->assertTrue($form->isSubmited());
        $this->assertTrue($form->isConfirmed());
        $this->assertFalse($form->isFinish());
        $form->submit();
        $this->assertTrue($form->isValid());
        $this->assertFalse($form->isConfirmed());
        $this->assertTrue($form->isFinish());
        $this->assertEquals($inputData, $form->getData()['test']);
    }

    public function testFormAddonValidaton()
    {
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form->addFieldset(TestCollectionFieldset::class);
        // データをセットして、そしてsubmit
        $formMeta = $form->getData();
        $inputData = [
            'collection' => [
                ['test' => 'test1'],
                ['test' => 'test2']
            ]
        ];
        $formMeta['test'] = $inputData;
        $form->setData($formMeta);
        $form->submit();
        $this->assertTrue($form->isValid());
        $this->assertTrue($form->isSubmited());
        $this->assertTrue($form->isConfirmed());
        $this->assertFalse($form->isFinish());
        $form->addEventListener(Form::TRIGGER_SUBMIT, function ($event) {
            $form = $event->getTarget();
            $form->forceError();
        });
        $form->submit();
        $this->assertFalse($form->isSubmited());
        $this->assertFalse($form->isValid());
        $this->assertFalse($form->isConfirmed());
        $this->assertFalse($form->isFinish());
    }

    public function testFormClear()
    {
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form->addFieldset(TestCollectionFieldset::class);
        // データをセットして、そしてsubmit
        $formMeta = $form->getData();
        $inputData = [
            'collection' => [
                ['test' => 'test1'],
                ['test' => 'test2']
            ]
        ];
        $formMeta['test'] = $inputData;
        $form->setData($formMeta);
        $form->submit();
        $this->assertTrue($form->isValid());
        $this->assertTrue($form->isSubmited());
        $this->assertTrue($form->isConfirmed());
        $this->assertFalse($form->isFinish());
        $this->assertEquals($inputData, $form->getData()['test']);
        $form->clear();
        $this->assertEmpty($form->getData()['test']);
    }

    /**
     *
     */
    public function testFormCollection2()
    {
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form->addFieldset(TestCollectionFieldset2::class);
        $TestCollection = $form->test->collection;
        $this->assertCount(1, $form->getFieldsets());
        $this->assertCount(5, $TestCollection);
        $this->assertEquals(5, $TestCollection->getCount());
        $this->assertInstanceof(FieldsetInterface::class, $TestCollection->getTemplate());
        // データをセットして、そしてsubmit
        $formMeta = $form->getData();
        $inputData = [
            'collection' => [
                ['test' => 'test1'],
                ['test' => 'test2']
            ]
        ];
        $formMeta['test'] = $inputData;
        $form->setData($formMeta);
        $this->assertCount(1, $form->getFieldsets());
        $this->assertCount(2, $TestCollection);
        $this->assertInstanceof(FieldsetInterface::class, $TestCollection->getTemplate());
        $ChildFieldset = $TestCollection->getFieldsets()[0];
        $this->assertEquals("<input type='text' name='test[collection][0][test]' value='test1' class='test'>", (string) $ChildFieldset->test);
        $form->submit();
        $this->assertTrue($form->isValid());
        $this->assertTrue($form->isSubmited());
        $this->assertTrue($form->isConfirmed());
        $this->assertFalse($form->isFinish());
        $form->submit();
        $this->assertTrue($form->isValid());
        $this->assertFalse($form->isConfirmed());
        $this->assertTrue($form->isFinish());
        $this->assertEquals($inputData, $form->getData()['test']);
    }

    /**
     */
    public function testInvalidFormCollection()
    {
        $this->expectException(\ErrorException::class);
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form->addFieldset(InvalidCollectionFieldset::class);
    }

    public function testInvalidFormCollection2()
    {
        $this->expectException(\InvalidArgumentException::class);
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form->addFieldset(InvalidCollectionFieldset2::class);
    }

    /**
     */
    public function testFormCollectionException1()
    {
        $this->expectException(\DomainException::class);
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form->addFieldset(TestCollectionFieldset::class);
        $this->assertCount(1, $form->getFieldsets());
        $this->assertCount(5, $form->test->collection);
        $this->assertTrue($form->test->collection->allowRemove());
        $form->test->collection->setAllowRemove(false);
        $this->assertFalse($form->test->collection->allowRemove());
        $formMeta = $form->getData();
        $formMeta['test'] = [
            'collection' => [
                ['test' => 'test1'],
                ['test' => 'test2']
            ]
        ];
        $form->setData($formMeta);
        $form->submit();
    }

    /**
     */
    public function testFormCollectionException2()
    {
        $this->expectException(\DomainException::class);
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form->addFieldset(TestCollectionFieldset::class);
        $this->assertCount(1, $form->getFieldsets());
        $this->assertCount(5, $form->test->collection);
        $this->assertTrue($form->test->collection->allowAdd());
        $form->test->collection->setAllowAdd(false);
        $this->assertFalse($form->test->collection->allowAdd());
        $formMeta = $form->getData();
        $formMeta['test'] = [
            'collection' => [
                ['test' => 'test1'],
                ['test' => 'test2'],
                ['test' => 'test3'],
                ['test' => 'test4'],
                ['test' => 'test5'],
                ['test' => 'test6'],
            ]
        ];
        $form->setData($formMeta);
        $form->submit();
    }

    /**
     *
     */
    public function testFieldsetClassEmptySubmit()
    {
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form->addFieldset(TestFieldset::class);
        $form->submit();
        $this->assertEmpty($form->isValid());
    }

    public function testFieldsetClassSubmit()
    {
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form->addFieldset(TestFieldset::class);
        // データをセットして、そしてsubmit
        $formMeta = $form->getData();
        $formMeta['Test'] = ['test' => 'test'];
        $form->setData($formMeta);
        $form->submit();
        $this->assertTrue($form->isValid());
    }

    /**
     *
     */
    public function testFieldsetInstance()
    {
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $this->assertCount(0, $form->getFieldsets());
        $this->assertCount(3, $form->getElements());
        $ObjectManager = ObjectManager::getSingleton();
        $fieldset = $ObjectManager->create(TestFieldset::class);
        $form->addFieldset($fieldset);
        $this->assertCount(1, $form->getFieldsets());
        $this->assertCount(3, $form->getElements());
        $fieldset2 = $ObjectManager->create(TestFieldset::class);
        $fieldset2->setName(__FUNCTION__);
        $form->addFieldset($fieldset2);
        $this->assertCount(2, $form->getFieldsets());
        $this->assertCount(3, $form->getElements());
        $formMeta = $form->getData();
        // データをセットして、そしてsubmit
        $formMeta['Test'] = ['test' => 'test'];
        $formMeta[__FUNCTION__] = ['test' => 'test'];
        $form->setData($formMeta);
        $form->submit();
        $this->assertTrue($form->isValid());
    }

    /**
     *
     */
    public function testElementsInstance()
    {
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $formMeta = $form->getAllElements();
        $form->addFieldset(TestElementFieldset::class);
        $Fieldset = $form->TestElement;
        $testKeys = [
            'text', 'checkbox', 'inline_checkbox', 'date', 'datetime', 'hidden', 'radio',
            'inline_radio', 'reset', 'select', 'span', 'submit', 'textarea', 'time', 'password'
        ];
        $elements = $Fieldset->getElements();
        $allElements = $form->getAllElements();
        $this->assertEquals(
            iterator_to_array($formMeta) + array_values($elements),
            iterator_to_array($allElements)
        );
        $this->assertEquals($testKeys, array_keys($elements));
        foreach ($elements as $Element) {
            $Element->addClass('addTestClass');
            $Element->addClass('addTestClass2');
            $Element->removeClass('addTestClass2');
            $elementString = (string) $Element;
            $this->assertNotEmpty($elementString);
            $this->assertStringContainsString('addTestClass', $elementString);
            $this->assertStringNotContainsString('addTestClass2', $elementString);
        }
        $testData = [
            'text' => 'test',
            'checkbox' => [1, 2],
            'inline_checkbox' => [1, 2],
            'date' => date('Y/m/d'),
            'datetime' => date('Y/m/d H:i:s'),
            'hidden' => 1,
            'radio' => 1,
            'inline_radio' => 1,
            'reset' => 'reset',
            'select' => 1,
            'span' => 'span',
            'submit' => 'submit',
            'textarea' => 'textarea',
            'time' => date('H:i:s'),
            'password' => 'password',
        ];
        $formMeta = $form->getData();
        $data = array_merge($formMeta, ['TestElement' => $testData]);
        $form->setData($data);
        $form->submit();
        $this->assertTrue($form->isValid());
        foreach ($elements as $Element) {
            $this->assertNotEmpty((string) $Element);
        }
        $form->clear();
        foreach ($elements as $Element) {
            $this->assertEmpty($Element->getValue());
        }
    }

    public function testFieldsetValidator()
    {
        $FormManager = ObjectManager::getSingleton()->get(FormManager::class);
        $form = $FormManager->create(__FUNCTION__);
        $form->addFieldset(TestElementFieldset::class);
        $this->assertInstanceof(InputFilterInterface::class, $form->TestElement->getInputFilter());
    }
}
