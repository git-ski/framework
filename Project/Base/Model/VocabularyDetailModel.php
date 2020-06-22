<?php
declare(strict_types=1);

namespace Project\Base\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Base\Entity\VocabularyDetail;
use Project\Base\Model\VocabularyHeaderModel;
use InvalidArgumentException;

class VocabularyDetailModel extends AbstractEntityModel implements
    EntityManagerAwareInterface,
    ConfigManagerAwareInterface,
    CryptManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;

    private $Repository;
    private static $VocabularyHeaderObjects;

    /**
     * Entityを作成
     *
     * @param array $data
     * @return EntityInterface
     */
    public function create($data) : EntityInterface
    {
        $VocabularyDetail = new VocabularyDetail();
        $data = $this->filterValues($data);
        if (isset($data['VocabularyHeader'])) {
            $VocabularyHeaderModel = $this->getObjectManager()->get(VocabularyHeaderModel::class);
            $data['VocabularyHeader'] = $VocabularyHeaderModel->get($data['VocabularyHeader']);
        }
        $VocabularyDetail->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $VocabularyDetail->setCreateDate($DateTime->format('Y-m-d'));
        $VocabularyDetail->setCreateTime($DateTime->format('H:i:s'));
        $VocabularyDetail->setCreateAdminId($this->getCreateAdminId());
        $VocabularyDetail->setUpdateDate($DateTime->format('Y-m-d'));
        $VocabularyDetail->setUpdateTime($DateTime->format('H:i:s'));
        $VocabularyDetail->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($VocabularyDetail);
        $this->getEntityManager()->flush();
        return $VocabularyDetail;
    }

    /**
     * DoctrineのBulk Insertを使って、大量データのinsertを効率化する
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/batch-processing.html#batch-processing
     *
     * @param Generator $dataGenerator
     * @param integer $batchSize
     * @return VocabularyDetailModel
     */
    public function bulkCreate(Generator $dataGenerator, $batchSize = 1000)
    {
        $index = 0;
        foreach ($dataGenerator as $data) {
            ++$index;
            $VocabularyDetail = new VocabularyDetail();
            $data = $this->filterValues($data);
            if (isset($data['VocabularyHeader'])) {
                $VocabularyHeaderModel = $this->getObjectManager()->get(VocabularyHeaderModel::class);
                $data['VocabularyHeader'] = $VocabularyHeaderModel->get($data['VocabularyHeader']);
            }
            $VocabularyDetail->fromArray($data);
            $DateTime = $this->getDateTimeForEntity();
            $VocabularyDetail->setCreateDate($DateTime->format('Y-m-d'));
            $VocabularyDetail->setCreateTime($DateTime->format('H:i:s'));
            $VocabularyDetail->setCreateAdminId($this->getCreateAdminId());
            $VocabularyDetail->setUpdateDate($DateTime->format('Y-m-d'));
            $VocabularyDetail->setUpdateTime($DateTime->format('H:i:s'));
            $VocabularyDetail->setUpdateAdminId($this->getUpdateAdminId());
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
    public function get($idOrVocabularyDetail)
    {
        if ($idOrVocabularyDetail instanceof VocabularyDetail) {
            return $idOrVocabularyDetail;
        }

        return $this->getRepository()->findOneBy([
            'vocabularyDetailId' => $idOrVocabularyDetail,
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
        if (empty($orderBy)) {
            $orderBy = [
                'showPriority' => 'DESC',
                'vocabularyDetailId' => 'ASC',
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
        if (empty($orderBy)) {
            $orderBy = [
                'showPriority' => 'DESC',
                'vocabularyDetailId' => 'ASC',
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
    public function update($idOrVocabularyDetail, $data = null) : EntityInterface
    {
        if (!$idOrVocabularyDetail instanceof EntityInterface) {
            $idOrVocabularyDetail = $this->get($idOrVocabularyDetail);
        }
        if (!$idOrVocabularyDetail instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: VocabularyDetail');
        }
        if ($data) {
            $data = $this->filterValues($data);
            if (isset($data['VocabularyHeader'])) {
                $VocabularyHeaderModel = $this->getObjectManager()->get(VocabularyHeaderModel::class);
                $data['VocabularyHeader'] = $VocabularyHeaderModel->get($data['VocabularyHeader']);
            }
            $idOrVocabularyDetail->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrVocabularyDetail->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrVocabularyDetail->setUpdateTime($DateTime->format('H:i:s'));
        $idOrVocabularyDetail->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrVocabularyDetail);
        $this->getEntityManager()->flush();
        return $idOrVocabularyDetail;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrVocabularyDetail) : EntityInterface
    {
        throw new InvalidArgumentException('VocabularyDetail にdeleteFlagが存在しないため、論理削除できません。');
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrVocabularyDetail)
    {
        $VocabularyDetail = $this->get($idOrVocabularyDetail);
        if (!$VocabularyDetail instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: VocabularyDetail');
        }
        $this->getEntityManager()->remove($VocabularyDetail);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(VocabularyDetail::class);
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
            'displayFlag' => [
                0 => 'VOCABULARYDETAIL_DISPLAYFLAG_OFF',
                1 => 'VOCABULARYDETAIL_DISPLAYFLAG_ON',
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
            'vocabularyDetailId' => 'VOCABULARYDETAIL_VOCABULARYDETAILID',
            'machineName' => 'VOCABULARYDETAIL_MACHINENAME',
            'name' => 'VOCABULARYDETAIL_NAME',
            'comment' => 'VOCABULARYDETAIL_COMMENT',
            'displayFlag' => 'VOCABULARYDETAIL_DISPLAYFLAG',
            'showPriority' => 'VOCABULARYDETAIL_SHOWPRIORITY',
            'createDate' => 'VOCABULARYDETAIL_CREATEDATE',
            'createTime' => 'VOCABULARYDETAIL_CREATETIME',
            'createAdminId' => 'VOCABULARYDETAIL_CREATEADMINID',
            'updateDate' => 'VOCABULARYDETAIL_UPDATEDATE',
            'updateTime' => 'VOCABULARYDETAIL_UPDATETIME',
            'updateAdminId' => 'VOCABULARYDETAIL_UPDATEADMINID',
            'VocabularyHeader' => 'VOCABULARYDETAIL_VOCABULARYHEADER',
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
        if (isset($data['vocabularyDetailId'])) {
            unset($data['vocabularyDetailId']);
        }
        // 空白文字列フィルター
        if (isset($data['comment']) && '' === $data['comment']) {
            unset($data['comment']);
        }
        if (isset($data['displayFlag']) && '' === $data['displayFlag']) {
            unset($data['displayFlag']);
        }
        if (isset($data['showPriority']) && '' === $data['showPriority']) {
            unset($data['showPriority']);
        }
        if (isset($data['VocabularyHeader']) && '' === $data['VocabularyHeader']) {
            unset($data['VocabularyHeader']);
        }
        return $data;
    }

    public static function getVocabularyHeaderObjects($label = null, array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        if (null === self::$VocabularyHeaderObjects) {
            self::$VocabularyHeaderObjects = [];
            $VocabularyHeaderModel = ObjectManager::getSingleton()->get(VocabularyHeaderModel::class);
            // 検索条件の拡張や調整はここ

            self::$VocabularyHeaderObjects = $VocabularyHeaderModel->getList($criteria, $orderBy, $limit, $offset);
        }
        if (null === $label) {
            $label = '';
        }
        $valueOptions = [];
        foreach (self::$VocabularyHeaderObjects as $VocabularyHeader) {
            $id                = $VocabularyHeader->getVocabularyHeaderId();
            $valueOptions[$id] = $VocabularyHeader->getVocabularyHeaderId();
        }
        return $valueOptions;
    }

    public static function getVocabularyHeaderObjectsHaystack()
    {
        $hayStack = [];
        if (null === self::$VocabularyHeaderObjects) {
            self::getVocabularyHeaderObjects();
        }
        foreach (self::$VocabularyHeaderObjects as $VocabularyHeader) {
            $hayStack[] = $VocabularyHeader->getVocabularyHeaderId();
        }
        return $hayStack;
    }
}
