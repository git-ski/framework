<?php
declare(strict_types=1);

namespace Project\Base\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Base\Entity\Country;
use InvalidArgumentException;

class CountryModel extends AbstractEntityModel implements
    EntityManagerAwareInterface,
    ConfigManagerAwareInterface,
    CryptManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;

    private $Repository;
    const LANGUAGE_JAPAN = "ja";
    const LANGUAGE_ENGLISH = 'en';
    const COUNTRY_JAPAN = "Japan(日本)";

    /**
     * Entityを作成
     *
     * @param array $data
     * @return EntityInterface
     */
    public function create($data) : EntityInterface
    {
        $Country = new Country();
        $data = $this->filterValues($data);
        $Country->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $Country->setCreateDate($DateTime->format('Y-m-d'));
        $Country->setCreateTime($DateTime->format('H:i:s'));
        $Country->setCreateAdminId($this->getCreateAdminId());
        $Country->setUpdateDate($DateTime->format('Y-m-d'));
        $Country->setUpdateTime($DateTime->format('H:i:s'));
        $Country->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($Country);
        $this->getEntityManager()->flush();
        return $Country;
    }

    /**
     * DoctrineのBulk Insertを使って、大量データのinsertを効率化する
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/batch-processing.html#batch-processing
     *
     * @param Generator $dataGenerator
     * @param integer $batchSize
     * @return CountryModel
     */
    public function bulkCreate(Generator $dataGenerator, $batchSize = 1000)
    {
        $index = 0;
        foreach ($dataGenerator as $data) {
            ++$index;
            $Country = new Country();
            $data = $this->filterValues($data);
            $Country->fromArray($data);
            $DateTime = $this->getDateTimeForEntity();
            $Country->setCreateDate($DateTime->format('Y-m-d'));
            $Country->setCreateTime($DateTime->format('H:i:s'));
            $Country->setCreateAdminId($this->getCreateAdminId());
            $Country->setUpdateDate($DateTime->format('Y-m-d'));
            $Country->setUpdateTime($DateTime->format('H:i:s'));
            $Country->setUpdateAdminId($this->getUpdateAdminId());
            if (($index % $batchSize) === 0) {
                $this->getEntityManager()->flush();
                $this->getEntityManager()->clear();
            }
        }
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
        return $this;
    }

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrCountry)
    {
        if ($idOrCountry instanceof Country) {
            return $idOrCountry;
        }

        return $this->getRepository()->findOneBy([
            'countryId' => $idOrCountry,
            'deleteFlag' => 0
        ]);
    }

    /**
     * CountryIdを取得
     * @param type $name
     * @return CountryId|null
     */
    public function getIdByCountryName($name)
    {
        if (!empty($name)) {
            $country = $this->getRepository()->findOneBy(['countryName' => $name,'deleteFlag' => 0]);
            if (!$country) {
                return null;
            }
            return $country->getCountryId();
        }
        return null;
    }

    /**
     * Entityを検索する
     *
     * @param array|null   $criteria
     * @param array|null   $orderBy
     * @param integer|null $limit
     * @param integer|null $offset
     * @return array
     */
    public function getList(array $criteria = [], array $orderBy = null, $limit = null, $offset = null) : Iterable
    {
        $criteria = array_merge([
            'deleteFlag' => 0
        ], $criteria);
        if (empty($orderBy)) {
            $orderBy = [
                'showPriority' => 'DESC',
                'countryId' => 'ASC',
            ];
        }
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * 条件付け、１つのEntityを取得する
     * deleteFlagを考慮する
     *
     * @param array $criteria
     * @param array $orderBy
     * @return EntityInterface
     */
    public function getOneBy(array $criteria, array $orderBy = null)
    {
        $criteria = array_merge([
            'deleteFlag' => 0
        ], $criteria);
        if (empty($orderBy)) {
            $orderBy = [
                'showPriority' => 'DESC',
                'countryId' => 'ASC',
            ];
        }
        return $this->getRepository()->findOneBy($criteria, $orderBy);
    }

    /**
     * Entityを更新する
     *
     * @param integer|EntityInterface $idOrEntity
     * @param array                   $data
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function update($idOrCountry, $data = null) : EntityInterface
    {
        if (!$idOrCountry instanceof EntityInterface) {
            $idOrCountry = $this->get($idOrCountry);
        }
        if (!$idOrCountry instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: Country');
        }
        if ($data) {
            $data = $this->filterValues($data);
            $idOrCountry->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrCountry->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrCountry->setUpdateTime($DateTime->format('H:i:s'));
        $idOrCountry->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrCountry);
        $this->getEntityManager()->flush();
        return $idOrCountry;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrCountry) : EntityInterface
    {
        $Country = $this->get($idOrCountry);
        if (!$Country instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: Country');
        }
        $Country->setDeleteFlag(true);
        $this->getEntityManager()->merge($Country);
        $this->getEntityManager()->flush();
        return $Country;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrCountry)
    {
        $Country = $this->get($idOrCountry);
        if (!$Country instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: Country');
        }
        $this->getEntityManager()->remove($Country);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(Country::class);
        }
        return $this->Repository;
    }

    /**
     * Entityの属性のvalue_listを返す
     *
     * @return array
     */
    public static function getValueOptions() : array
    {
        return [
            'deleteFlag' => [
                0 => 'COUNTRY_DELETEFLAG_OFF',
                1 => 'COUNTRY_DELETEFLAG_ON',
            ],
        ];
    }

    /**
     * 属性のラベルを取得
     *
     * @param string $property
     * @return string
     */
    public static function getPropertyLabel($property) : string
    {
        $propertyLabels = [
            'countryId' => 'COUNTRY_COUNTRYID',
            'countryName' => 'COUNTRY_COUNTRYNAME',
            'showPriority' => 'COUNTRY_SHOWPRIORITY',
            'createDate' => 'COUNTRY_CREATEDATE',
            'createTime' => 'COUNTRY_CREATETIME',
            'createAdminId' => 'COUNTRY_CREATEADMINID',
            'updateDate' => 'COUNTRY_UPDATEDATE',
            'updateTime' => 'COUNTRY_UPDATETIME',
            'updateAdminId' => 'COUNTRY_UPDATEADMINID',
            'deleteFlag' => 'COUNTRY_DELETEFLAG',
        ];
        $propertyLabel = $propertyLabels[$property] ?? '';
        return parent::getPropertyLabel((string) $propertyLabel);
    }

    /**
     * 文字列でないカラムの保存時に、空白の文字列をセットするとエラーになる
     * そのため、保存前に、空白の文字列をフィルターする
     * 特定のカラムの空値を特別扱うためには、カラムごとの処理を持つ。
     * 注意、数値型などでは、0が入る可能性もあるため、厳密なnullチェックを行うこと
     * 注意２、文字列などのカラムはそもそも空白文字列が入ることも想定するので、逆にフィルターしてはいけない。
     * また、主キーなど、更新対象にならないカラムはunsetしておく
     * 主キーを更新したい場合は明示的にここのフィルターを解除する。
     *
     * @param array $data
     * @return array
     */
    public function filterValues($data) : array
    {
        // 主キーフィルター
        if (isset($data['countryId'])) {
            unset($data['countryId']);
        }
        // 空白文字列フィルター
        if (isset($data['showPriority']) && '' === $data['showPriority']) {
            unset($data['showPriority']);
        }
        return $data;
    }
}
