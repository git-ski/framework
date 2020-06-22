<?php
declare(strict_types=1);

namespace Project\Base\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Base\Entity\ZipcodeJa;
use InvalidArgumentException;

class ZipcodeJaModel extends AbstractEntityModel implements
    EntityManagerAwareInterface,
    ConfigManagerAwareInterface,
    CryptManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;

    private $Repository;

    /**
     * Entityを作成
     *
     * @param array $data
     * @return EntityInterface
     */
    public function create($data) : EntityInterface
    {
        $ZipcodeJa = new ZipcodeJa();
        $data = $this->filterValues($data);
        $ZipcodeJa->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $ZipcodeJa->setCreateDate($DateTime->format('Y-m-d'));
        $ZipcodeJa->setCreateTime($DateTime->format('H:i:s'));
        $ZipcodeJa->setCreateAdminId($this->getCreateAdminId());
        $ZipcodeJa->setUpdateDate($DateTime->format('Y-m-d'));
        $ZipcodeJa->setUpdateTime($DateTime->format('H:i:s'));
        $ZipcodeJa->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($ZipcodeJa);
        $this->getEntityManager()->flush();
        return $ZipcodeJa;
    }

    /**
     * DoctrineのBulk Insertを使って、大量データのinsertを効率化する
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/batch-processing.html#batch-processing
     *
     * @param Generator $dataGenerator
     * @param integer $batchSize
     * @return ZipcodeJaModel
     */
    public function bulkCreate(Generator $dataGenerator, $batchSize = 1000)
    {
        $index = 0;
        foreach ($dataGenerator as $data) {
            ++$index;
            $ZipcodeJa = new ZipcodeJa();
            $data = $this->filterValues($data);
            $ZipcodeJa->fromArray($data);
            $DateTime = $this->getDateTimeForEntity();
            $ZipcodeJa->setCreateDate($DateTime->format('Y-m-d'));
            $ZipcodeJa->setCreateTime($DateTime->format('H:i:s'));
            $ZipcodeJa->setCreateAdminId($this->getCreateAdminId());
            $ZipcodeJa->setUpdateDate($DateTime->format('Y-m-d'));
            $ZipcodeJa->setUpdateTime($DateTime->format('H:i:s'));
            $ZipcodeJa->setUpdateAdminId($this->getUpdateAdminId());
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
    public function get($idOrZipcodeJa)
    {
        if ($idOrZipcodeJa instanceof ZipcodeJa) {
            return $idOrZipcodeJa;
        }

        return $this->getRepository()->findOneBy([
            'zipcodeJaId' => $idOrZipcodeJa,
            'deleteFlag' => 0
        ]);
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
                'zipcodeJaId' => 'ASC',
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
                'zipcodeJaId' => 'ASC',
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
    public function update($idOrZipcodeJa, $data = null) : EntityInterface
    {
        if (!$idOrZipcodeJa instanceof EntityInterface) {
            $idOrZipcodeJa = $this->get($idOrZipcodeJa);
        }
        if (!$idOrZipcodeJa instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: ZipcodeJa');
        }
        if ($data) {
            $data = $this->filterValues($data);
            $idOrZipcodeJa->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrZipcodeJa->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrZipcodeJa->setUpdateTime($DateTime->format('H:i:s'));
        $idOrZipcodeJa->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrZipcodeJa);
        $this->getEntityManager()->flush();
        return $idOrZipcodeJa;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrZipcodeJa) : EntityInterface
    {
        $ZipcodeJa = $this->get($idOrZipcodeJa);
        if (!$ZipcodeJa instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: ZipcodeJa');
        }
        $ZipcodeJa->setDeleteFlag(true);
        $this->getEntityManager()->merge($ZipcodeJa);
        $this->getEntityManager()->flush();
        return $ZipcodeJa;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrZipcodeJa)
    {
        $ZipcodeJa = $this->get($idOrZipcodeJa);
        if (!$ZipcodeJa instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: ZipcodeJa');
        }
        $this->getEntityManager()->remove($ZipcodeJa);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(ZipcodeJa::class);
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
                0 => 'ZIPCODEJA_DELETEFLAG_OFF',
                1 => 'ZIPCODEJA_DELETEFLAG_ON',
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
            'zipcodeJaId' => 'ZIPCODEJA_ZIPCODEJAID',
            'zipCd' => 'ZIPCODEJA_ZIPCD',
            'mPrefectureId' => 'ZIPCODEJA_MPREFECTUREID',
            'address01' => 'ZIPCODEJA_ADDRESS01',
            'address02' => 'ZIPCODEJA_ADDRESS02',
            'createDate' => 'ZIPCODEJA_CREATEDATE',
            'createTime' => 'ZIPCODEJA_CREATETIME',
            'createAdminId' => 'ZIPCODEJA_CREATEADMINID',
            'updateDate' => 'ZIPCODEJA_UPDATEDATE',
            'updateTime' => 'ZIPCODEJA_UPDATETIME',
            'updateAdminId' => 'ZIPCODEJA_UPDATEADMINID',
            'deleteFlag' => 'ZIPCODEJA_DELETEFLAG',
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
        if (isset($data['zipcodeJaId'])) {
            unset($data['zipcodeJaId']);
        }
        // 空白文字列フィルター
        if (isset($data['mPrefectureId']) && '' === $data['mPrefectureId']) {
            unset($data['mPrefectureId']);
        }
        return $data;
    }
}
