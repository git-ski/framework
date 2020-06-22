<?php

namespace Test\Std\EntityManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Project\Base\Model\CountryModel;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Laminas\I18n\Translator\Translator;
use DateTimeImmutable;

/**
 * Class EntityModelTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\EntityManager\AbstractEntityModel
 */
class EntityModelTest extends TestCase
{
    /**
     * @var AbstractEntityModel $abstractEntityModel An instance of "AbstractEntityModel" to test.
     */
    private $EntityModel;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $ObjectManager = ObjectManager::getSingleton();
        $this->EntityModel = $ObjectManager->get(CountryModel::class);
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::getPropertyValue
     */
    public function testGetPropertyValue(): void
    {
        $this->assertSame(0, $this->EntityModel->getPropertyValue('deleteFlag', 'COUNTRY_DELETEFLAG_OFF'));
        $this->assertFalse($this->EntityModel->getPropertyValue(__CLASS__, __METHOD__));
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::getPropertyValueOptions
     */
    public function testGetPropertyValueOptions(): void
    {
        $this->assertIsArray($this->EntityModel->getPropertyValueOptions('deleteFlag'));
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::getPropertyHaystack
     */
    public function testGetPropertyHaystack(): void
    {
        // Haystack is used as string for Fieldset-validation
        $this->assertSame(
            ['0', '1'],
            $this->EntityModel->getPropertyHaystack('deleteFlag')
        );
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::getPropertyValueConst
     */
    public function testGetPropertyValueConst(): void
    {
        $this->assertSame('COUNTRY_DELETEFLAG_OFF', $this->EntityModel->getPropertyValueConst('deleteFlag', 0));
        $this->assertNotSame('COUNTRY_DELETEFLAG_OFF', $this->EntityModel->getPropertyValueConst('deleteFlag', 1));
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::getPropertyValueLabel
     */
    public function testGetPropertyValueLabel(): void
    {
        $this->assertNotNull($this->EntityModel->getPropertyValueLabel('deleteFlag', 0));
        $this->assertIsString($this->EntityModel->getPropertyValueLabel('deleteFlag', 0));
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::create
     */
    public function testCreate(): void
    {
        $Entity = $this->EntityModel->create([]);
        $DateTimeForEntity = $this->EntityModel->getDateTimeForEntity();
        $this->assertTrue($Entity instanceof EntityInterface);
        $this->assertSame($Entity->getCreateDate(), $DateTimeForEntity->format('Y-m-d'));
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::get
     */
    public function testGet(): void
    {
        $Entity = $this->EntityModel->get(1);
        $this->assertTrue($Entity instanceof EntityInterface);
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::getList
     */
    public function testGetList(): void
    {
        foreach ($this->EntityModel->getList() as $Entity) {
            $this->assertTrue($Entity instanceof EntityInterface);
        }
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::update
     */
    public function testUpdate(): void
    {
        $Entity = $this->EntityModel->update(1, []);
        $DateTimeForEntity = $this->EntityModel->getDateTimeForEntity();
        $this->assertTrue($Entity instanceof EntityInterface);
        $this->assertSame($Entity->getUpdateDate(), $DateTimeForEntity->format('Y-m-d'));
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::delete
     */
    public function testDelete(): void
    {
        $Entity = $this->EntityModel->delete(1);
        $this->assertTrue($Entity instanceof EntityInterface);
        $this->assertTrue($Entity->getDeleteFlag());
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::filterValues
     */
    public function testFilterValues(): void
    {
        $dirty = [
            'countryName' => '', // 文字型は、空白文字列として受け入れる・
            'createDateTime' => null, // 文字列は、nullも受け入れる
            'showPriority' => '', //　数字型は、空白文字列を受け入れないので、フィルタ対応
            'deleteFlag' => 0 // 数字型は、数字を受け入れる。
        ];
        $expected = [
            'countryName' => '',
            'createDateTime' => null,
            'deleteFlag' => 0
        ];
        $this->assertSame($expected, $this->EntityModel->filterValues($dirty));
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::getValueOptions
     */
    public function testGetValueOptions(): void
    {
        $this->assertIsArray($this->EntityModel->getValueOptions());
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::getPropertyLabel
     */
    public function testGetPropertyLabel(): void
    {
        $this->assertIsString($this->EntityModel->getPropertyLabel('deleteFlag'));
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::getTranslator
     * @covers \Std\EntityManager\AbstractEntityModel::getEntityTranslator
     */
    public function testGetTranslator(): void
    {
        $this->assertTrue(
            $this->EntityModel->getTranslator() instanceof Translator
        );
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::getDateTimeForEntity
     */
    public function testGetDateTimeForEntity(): void
    {
        $this->assertTrue(
            $this->EntityModel->getDateTimeForEntity() instanceof DateTimeImmutable
        );
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::setDefaultCreateAdminId
     */
    public function testSetDefaultCreateAdminId(): void
    {
        $expected = 1;

        $property = (new \ReflectionClass($this->EntityModel))
            ->getProperty('defaultCreateAdminId');
        $property->setAccessible(true);
        AbstractEntityModel::setDefaultCreateAdminId($expected);

        $this->assertSame($expected, $property->getValue(null));
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::setCreateAdminId
     */
    public function testSetCreateAdminId(): void
    {
        $expected = 1;

        $property = (new \ReflectionClass($this->EntityModel))
            ->getProperty('createAdminId');
        $property->setAccessible(true);
        $this->EntityModel->setCreateAdminId($expected);

        $this->assertSame($expected, $property->getValue($this->EntityModel));
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::getCreateAdminId
     */
    public function testGetCreateAdminId(): void
    {
        $expected = 1;

        $property = (new \ReflectionClass($this->EntityModel))
            ->getProperty('createAdminId');
        $property->setAccessible(true);
        $property->setValue($this->EntityModel, $expected);

        $this->assertSame($expected, $this->EntityModel->getCreateAdminId());
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::setDefaultUpdateAdminId
     */
    public function testSetDefaultUpdateAdminId(): void
    {
        $expected = 1;

        $property = (new \ReflectionClass($this->EntityModel))
            ->getProperty('defaultUpdateAdminId');
        $property->setAccessible(true);
        AbstractEntityModel::setDefaultUpdateAdminId($expected);

        $this->assertSame($expected, $property->getValue(null));
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::setUpdateAdminId
     */
    public function testSetUpdateAdminId(): void
    {
        $expected = 1;

        $property = (new \ReflectionClass($this->EntityModel))
            ->getProperty('updateAdminId');
        $property->setAccessible(true);
        $this->EntityModel->setUpdateAdminId($expected);

        $this->assertSame($expected, $property->getValue($this->EntityModel));
    }

    /**
     * @covers \Std\EntityManager\AbstractEntityModel::getUpdateAdminId
     */
    public function testGetUpdateAdminId(): void
    {
        $expected = 1;

        $property = (new \ReflectionClass($this->EntityModel))
            ->getProperty('updateAdminId');
        $property->setAccessible(true);
        $property->setValue($this->EntityModel, $expected);

        $this->assertSame($expected, $this->EntityModel->getUpdateAdminId());
    }
}
