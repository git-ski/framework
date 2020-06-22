<?php
/**
 * PHP version 7
 * File EntityModelInterface.php
 *
 * @category Class
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\EntityManager;

use Framework\ObjectManager\SingletonInterface;
use Std\EntityManager\EntityInterface;
use Laminas\I18n\Translator\Translator;

/**
 * Interface EntityModelInterface
 *
 * @category Interface
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface EntityModelInterface extends SingletonInterface
{
    const ACTION_CREATE = 'create';
    const ACTION_READ   = 'get';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';

    /**
     * Entityを作成
     *
     * @param array $data
     * @return EntityInterface
     */
    public function create($data) : EntityInterface;

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($id);

    /**
     * Entityを検索する
     *
     * @param array|null   $criteria
     * @param array|null   $orderBy
     * @param integer|null $limit
     * @param integer|null $offset
     * @return array
     */
    public function getList(array $criteria = [], array $orderBy = null, $limit = null, $offset = null) : Iterable;

    /**
     * Entityを更新する
     *
     * @param integer|EntityInterface $idOrEntity
     * @param array|null              $data
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function update($idOrEntity, $data = null) : EntityInterface;

    /**
     * Entityを削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrEntity) : EntityInterface;

    /**
     * 文字列でないカラムの保存時に、空白の文字列をセットするとエラーになる
     * そのため、保存前に、空白の文字列をフィルターする
     * 特定のカラムの空値を特別扱うためには、カラムごとの処理を持つ。
     *
     * @param array $data
     * @return array
     */
    public function filterValues($data) : array;

    /**
     * Entityの属性のvalue_listを返す
     *
     * @return array
     */
    public static function getValueOptions() : array;

    /**
     * 指定属性の指定constから、対応する属性の値を逆引きする
     *
     * @param string $property
     * @param string $const
     * @return integer|null
     */
    public static function getPropertyValue($property, $const);

    /**
     * 属性のラベルを取得
     *
     * @param string $property
     * @return string
     */
    public static function getPropertyLabel($property) : string;

    /**
     * 指定属性のvalue_optionsを返す
     *
     * @param string $property
     * @return array
     */
    public static function getPropertyValueOptions($property) : array;

    /**
     * 指定属性のhaystackを返す
     *
     * @param string $property
     * @return array
     */
    public static function getPropertyHaystack($property) : array;

    /**
     * 指定属性の指定値のconstを取得
     * getPropertyValueの処理と真逆
     *
     * @param string $property
     * @param integer $value
     * @return string|null
     */
    public static function getPropertyValueConst($property, $value);

    /**
     * 指定属性の指定値のlabelを取得
     * getPropertyValueConstで取得した値の翻訳データ
     *
     * @param string $property
     * @param integer $value
     * @return string
     */
    public static function getPropertyValueLabel($property, $value) : string;

    /**
     * EntityModelのTranslatorを取得
     * 各EntityModelには、共通のEntity用Translatorをもつ。
     * Entity用Translator自体の翻訳データ設定は、EntityManagerモジュールの初期化で設定される。
     *
     * @return Translator
     */
    public function getTranslator() : Translator;
}
