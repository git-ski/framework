<?php

namespace Test\Std\ValidatorManager;

use Framework\ObjectManager\ObjectManager;
use PHPUnit\Framework\TestCase;
use Std\ValidatorManager\ValidatorManager;
use Laminas\InputFilter\InputFilterInterface;

/**
 * Class ValidatorManagerTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\ValidatorManager\ValidatorManager
 */
class ValidatorManagerTest extends TestCase
{
    /**
     * @var ValidatorManager $validatorManager An instance of "ValidatorManager" to test.
     */
    private $validatorManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $ObjectManager = ObjectManager::getSingleton();
        $this->validatorManager = $ObjectManager->get(ValidatorManager::class);
    }

    /**
     * @covers \Std\ValidatorManager\ValidatorManager::createInputFilter
     */
    public function testCreateInputFilter(): void
    {
        $inputFilter = $this->validatorManager->createInputFilter([
            'name' => 'name',
            'required' => true,
            'filters' => [
                [
                    'name' => 'Laminas\Filter\StringTrim',
                    'options' => [],
                ],
            ],
            'validators' => [],
            'description' => 'Hello to name',
            'allow_empty' => false,
            'continue_if_empty' => false,
        ]);
        $inputFilter->setData([
            'name' => 'test'
        ]);
        $this->assertTrue($inputFilter->isValid());
        // 同じinputfilterは重複に生成しない
        $this->assertSame($inputFilter, $this->validatorManager->createInputFilter($inputFilter));
    }

    /**
     * @covers \Std\ValidatorManager\ValidatorManager::createValidator
     */
    public function testCreateValidator(): void
    {
        $validator = $this->validatorManager->createValidator([
            [
                'name' => 'name',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'Laminas\Filter\StringTrim',
                        'options' => [],
                    ],
                ],
                'validators' => [],
                'description' => 'Hello to name',
                'allow_empty' => false,
                'continue_if_empty' => false,
            ],
            [
                'name' => 'kana',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'Laminas\Filter\StringTrim',
                        'options' => [],
                    ],
                ],
                'validators' => [],
                'description' => 'Hello to name',
                'allow_empty' => false,
                'continue_if_empty' => false,
            ],
        ]);
        $validator->setData([
            'name' => 'test',
            'kana' => 'kana',
        ]);
        $this->assertTrue($validator->isValid());
    }
}
