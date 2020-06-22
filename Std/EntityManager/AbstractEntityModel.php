<?php
/**
 * PHP version 7
 * File EntityModelTrait.php
 *
 * @category Interface
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\EntityManager;

use Framework\ObjectManager\ObjectManager;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\TranslatorManager\TranslatorManagerInterface;
use Laminas\I18n\Translator\Translator;
use Std\EntityManager\EntityInterface;
use DateTimeImmutable;

/**
 * Trait EntityModelTrait
 *
 * @category Trait
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
abstract class AbstractEntityModel implements
    EntityModelInterface,
    ObjectManagerAwareInterface
{
    use \Framework\ObjectManager\SingletonTrait;
    use \Framework\ObjectManager\ObjectManagerAwareTrait;

    protected $createAdminId;
    protected $updateAdminId;
    protected static $defaultCreateAdminId = 1;
    protected static $defaultUpdateAdminId = 1;
    protected static $DateTime;

    /**
     * @var Translator
     */
    private static $Translator;

    private function __construct()
    {
        // private __construct for singleton
    }

    /**
     * 指定属性の指定constから、対応する属性の値を逆引きする
     *
     * @param string $property
     * @param string $const
     * @return integer|null
     */
    public static function getPropertyValue($property, $const)
    {
        $ValueOptions    = static::getValueOptions();
        $propertyConfig  = $ValueOptions[$property] ?? [];
        return array_search($const, $propertyConfig);
    }

    /**
     * Entityの指定する属性のvalue_listを返す
     *
     * @param string $property
     * @return array
     */
    public static function getPropertyValueOptions($property) : array
    {
        $ValueOptions = static::getValueOptions();
        $PropertyValueOptions = $ValueOptions[$property] ?? [];
        return array_map(
            [self::getEntityTranslator(), 'translate'],
            $PropertyValueOptions
        );
    }

    /**
     * 指定属性のhaystackを返す
     *
     * @param string $property
     * @return array
     */
    public static function getPropertyHaystack($property) : array
    {
        $ValueOptions    = static::getValueOptions();
        $propertyConfig  = $ValueOptions[$property] ?? [];
        return array_map('strval', array_keys($propertyConfig));
    }

    /**
     * 指定属性の指定値のconstを取得
     * getPropertyValueの処理と真逆
     *
     * @param string $property
     * @param integer $value
     * @return string|null
     */
    public static function getPropertyValueConst($property, $value)
    {
        $ValueOptions    = static::getValueOptions();
        $propertyConfig  = $ValueOptions[$property] ?? [];
        return $propertyConfig[$value] ?? null;
    }

    /**
     * 指定属性の指定値のlabelを取得
     * getPropertyValueConstで取得した値の翻訳データ
     *
     * @param string $property
     * @param integer $value
     * @return string
     */
    public static function getPropertyValueLabel($property, $value) : string
    {
        $propertyValueConst = static::getPropertyValueConst($property, $value);
        return self::getEntityTranslator()->translate((string) $propertyValueConst);
    }

    /**
     * Entityを作成
     *
     * @param array $data
     * @return EntityInterface
     */
    abstract public function create($data) : EntityInterface;

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    abstract public function get($id);

    /**
     * Entityを検索する
     *
     * @param array|null   $criteria
     * @param array|null   $orderBy
     * @param integer|null $limit
     * @param integer|null $offset
     * @return array
     */
    abstract public function getList(array $criteria = [], array $orderBy = null, $limit = null, $offset = null) : Iterable;

    /**
     * Entityを更新する
     *
     * @param integer|EntityInterface $idOrEntity
     * @param array                   $data
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    abstract public function update($idOrEntity, $data = null) : EntityInterface;

    /**
     * Entityを削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    abstract public function delete($idOrEntity) : EntityInterface;

    /**
     * 文字列でないカラムの保存時に、空白の文字列をセットするとエラーになる
     * そのため、保存前に、空白の文字列をフィルターする
     * 特定のカラムの空値を特別扱うためには、カラムごとの処理を持つ。
     * このメソッドは共通でplaceholderのみを提供する
     * 実際の実装は各EntityModelで行う。
     *
     * @param array $data
     * @return array
     */
    abstract public function filterValues($data) : array;

    /**
     * Entityの属性のvalue_listを返す
     *
     * @return array
     */
    abstract public static function getValueOptions() : array;

    /**
     * 属性のラベルを取得
     *
     * @param string $property
     * @return string
     */
    public static function getPropertyLabel($property) : string
    {
        return self::getEntityTranslator()->translate($property);
    }

    /**
     * EntityModelのTranslatorを取得
     * 各EntityModelには、共通のEntity用Translatorをもつ。
     * Entity用Translator自体の翻訳データ設定は、EntityManagerモジュールの初期化で設定される。
     *
     * @return Translator
     */
    public function getTranslator() : Translator
    {
        return self::getEntityTranslator();
    }

    private static function getEntityTranslator() : Translator
    {
        if (null === self::$Translator) {
            $ObjectManager     = ObjectManager::getSingleton();
            $TranslatorManager = $ObjectManager->get(TranslatorManagerInterface::class);
            self::$Translator  = $TranslatorManager->getTranslator(EntityInterface::class);
        }
        return self::$Translator;
    }

    public function getDateTimeForEntity()
    {
        if (null === self::$DateTime) {
            self::$DateTime = new DateTimeImmutable();
        }
        return self::$DateTime;
    }

    public static function setDefaultCreateAdminId($createAdminId)
    {
        static::$defaultCreateAdminId = $createAdminId;
    }

    public function setCreateAdminId($createAdminId)
    {
        $this->createAdminId = $createAdminId;
    }

    public function getCreateAdminId()
    {
        if (null === $this->createAdminId) {
            $this->createAdminId = self::$defaultCreateAdminId;
        }
        return $this->createAdminId;
    }

    public static function setDefaultUpdateAdminId($updateAdminId)
    {
        static::$defaultUpdateAdminId = $updateAdminId;
    }

    public function setUpdateAdminId($updateAdminId)
    {
        $this->updateAdminId = $updateAdminId;
    }

    public function getUpdateAdminId()
    {
        if (null === $this->updateAdminId) {
            $this->updateAdminId = self::$defaultUpdateAdminId;
        }
        return $this->updateAdminId;
    }
}
