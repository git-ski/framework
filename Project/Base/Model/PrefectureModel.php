<?php
declare(strict_types=1);

namespace Project\Base\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Base\Entity\Prefecture;
use InvalidArgumentException;

class PrefectureModel extends AbstractEntityModel implements
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
        $Prefecture = new Prefecture();
        $data = $this->filterValues($data);
        $Prefecture->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $Prefecture->setCreateDate($DateTime->format('Y-m-d'));
        $Prefecture->setCreateTime($DateTime->format('H:i:s'));
        $Prefecture->setCreateAdminId($this->getCreateAdminId());
        $Prefecture->setUpdateDate($DateTime->format('Y-m-d'));
        $Prefecture->setUpdateTime($DateTime->format('H:i:s'));
        $Prefecture->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($Prefecture);
        $this->getEntityManager()->flush();
        return $Prefecture;
    }

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrPrefecture)
    {
        if ($idOrPrefecture instanceof Prefecture) {
            return $idOrPrefecture;
        }

        return $this->getRepository()->findOneBy([
            'prefectureId' => $idOrPrefecture,
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
        if (empty($criteria)) {
            $criteria = [
                'deleteFlag' => 0
            ];
        }
        if (empty($orderBy)) {
            $orderBy = [
                'showPriority' => 'DESC',
                'prefectureId' => 'ASC',
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
        $criteria = array_merge($criteria, [
            'deleteFlag' => 0
        ]);
        if (empty($orderBy)) {
            $orderBy = [
                'showPriority' => 'DESC',
                'prefectureId' => 'ASC',
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
    public function update($idOrPrefecture, $data = null) : EntityInterface
    {
        if (!$idOrPrefecture instanceof EntityInterface) {
            $idOrPrefecture = $this->get($idOrPrefecture);
        }
        if (!$idOrPrefecture instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: Prefecture');
        }
        if ($data) {
            $data = $this->filterValues($data);
            $idOrPrefecture->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrPrefecture->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrPrefecture->setUpdateTime($DateTime->format('H:i:s'));
        $idOrPrefecture->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrPrefecture);
        $this->getEntityManager()->flush();
        return $idOrPrefecture;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrPrefecture) : EntityInterface
    {
        if (!$idOrPrefecture instanceof EntityInterface) {
            $idOrPrefecture = $this->get($idOrPrefecture);
        }
        if (!$idOrPrefecture instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: Prefecture');
        }
        $idOrPrefecture->setDeleteFlag(true);
        $this->getEntityManager()->merge($idOrPrefecture);
        $this->getEntityManager()->flush();
        return $idOrPrefecture;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrPrefecture)
    {
        if (!$idOrPrefecture instanceof EntityInterface) {
            $idOrPrefecture = $this->get($idOrPrefecture);
        }
        if (!$idOrPrefecture instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: Prefecture');
        }
        $this->getEntityManager()->remove($idOrPrefecture);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(Prefecture::class);
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
                0 => 'PREFECTURE_DELETEFLAG_OFF',
                1 => 'PREFECTURE_DELETEFLAG_ON',
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
            'prefectureId' => 'PREFECTURE_PREFECTUREID',
            'prefectureName' => 'PREFECTURE_PREFECTURENAME',
            'romanName' => 'PREFECTURE_ROMANNAME',
            'showPriority' => 'PREFECTURE_SHOWPRIORITY',
            'createDate' => 'PREFECTURE_CREATEDATE',
            'createTime' => 'PREFECTURE_CREATETIME',
            'createAdminId' => 'PREFECTURE_CREATEADMINID',
            'updateDate' => 'PREFECTURE_UPDATEDATE',
            'updateTime' => 'PREFECTURE_UPDATETIME',
            'updateAdminId' => 'PREFECTURE_UPDATEADMINID',
            'deleteFlag' => 'PREFECTURE_DELETEFLAG',
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
        if (isset($data['prefectureId'])) {
            unset($data['prefectureId']);
        }
        // 空白文字列フィルター
        if (isset($data['showPriority']) && '' === $data['showPriority']) {
            unset($data['showPriority']);
        }
        return $data;
    }
}
