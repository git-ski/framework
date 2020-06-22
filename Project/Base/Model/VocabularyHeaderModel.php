<?php
declare(strict_types=1);

namespace Project\Base\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Base\Entity\VocabularyHeader;
use InvalidArgumentException;

class VocabularyHeaderModel extends AbstractEntityModel implements
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
        $VocabularyHeader = new VocabularyHeader();
        $data = $this->filterValues($data);
        $VocabularyHeader->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $VocabularyHeader->setCreateDate($DateTime->format('Y-m-d'));
        $VocabularyHeader->setCreateTime($DateTime->format('H:i:s'));
        $VocabularyHeader->setCreateAdminId($this->getCreateAdminId());
        $VocabularyHeader->setUpdateDate($DateTime->format('Y-m-d'));
        $VocabularyHeader->setUpdateTime($DateTime->format('H:i:s'));
        $VocabularyHeader->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($VocabularyHeader);
        $this->getEntityManager()->flush();
        return $VocabularyHeader;
    }

    /**
     * DoctrineのBulk Insertを使って、大量データのinsertを効率化する
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/batch-processing.html#batch-processing
     *
     * @param Generator $dataGenerator
     * @param integer $batchSize
     * @return VocabularyHeaderModel
     */
    public function bulkCreate(Generator $dataGenerator, $batchSize = 1000)
    {
        $index = 0;
        foreach ($dataGenerator as $data) {
            ++$index;
            $VocabularyHeader = new VocabularyHeader();
            $data = $this->filterValues($data);
            $VocabularyHeader->fromArray($data);
            $DateTime = $this->getDateTimeForEntity();
            $VocabularyHeader->setCreateDate($DateTime->format('Y-m-d'));
            $VocabularyHeader->setCreateTime($DateTime->format('H:i:s'));
            $VocabularyHeader->setCreateAdminId($this->getCreateAdminId());
            $VocabularyHeader->setUpdateDate($DateTime->format('Y-m-d'));
            $VocabularyHeader->setUpdateTime($DateTime->format('H:i:s'));
            $VocabularyHeader->setUpdateAdminId($this->getUpdateAdminId());
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
    public function get($idOrVocabularyHeader)
    {
        if ($idOrVocabularyHeader instanceof VocabularyHeader) {
            return $idOrVocabularyHeader;
        }

        return $this->getRepository()->findOneBy([
            'vocabularyHeaderId' => $idOrVocabularyHeader,
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
                'vocabularyHeaderId' => 'ASC',
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
                'vocabularyHeaderId' => 'ASC',
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
    public function update($idOrVocabularyHeader, $data = null) : EntityInterface
    {
        if (!$idOrVocabularyHeader instanceof EntityInterface) {
            $idOrVocabularyHeader = $this->get($idOrVocabularyHeader);
        }
        if (!$idOrVocabularyHeader instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: VocabularyHeader');
        }
        if ($data) {
            $data = $this->filterValues($data);
            $idOrVocabularyHeader->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrVocabularyHeader->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrVocabularyHeader->setUpdateTime($DateTime->format('H:i:s'));
        $idOrVocabularyHeader->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrVocabularyHeader);
        $this->getEntityManager()->flush();
        return $idOrVocabularyHeader;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrVocabularyHeader) : EntityInterface
    {
        throw new InvalidArgumentException('VocabularyHeader にdeleteFlagが存在しないため、論理削除できません。');
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrVocabularyHeader)
    {
        $VocabularyHeader = $this->get($idOrVocabularyHeader);
        if (!$VocabularyHeader instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: VocabularyHeader');
        }
        $this->getEntityManager()->remove($VocabularyHeader);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(VocabularyHeader::class);
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
            'vocabularyHeaderId' => 'VOCABULARYHEADER_VOCABULARYHEADERID',
            'machineName' => 'VOCABULARYHEADER_MACHINENAME',
            'name' => 'VOCABULARYHEADER_NAME',
            'comment' => 'VOCABULARYHEADER_COMMENT',
            'showPriority' => 'VOCABULARYHEADER_SHOWPRIORITY',
            'createDate' => 'VOCABULARYHEADER_CREATEDATE',
            'createTime' => 'VOCABULARYHEADER_CREATETIME',
            'createAdminId' => 'VOCABULARYHEADER_CREATEADMINID',
            'updateDate' => 'VOCABULARYHEADER_UPDATEDATE',
            'updateTime' => 'VOCABULARYHEADER_UPDATETIME',
            'updateAdminId' => 'VOCABULARYHEADER_UPDATEADMINID',
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
        if (isset($data['vocabularyHeaderId'])) {
            unset($data['vocabularyHeaderId']);
        }
        // 空白文字列フィルター
        if (isset($data['comment']) && '' === $data['comment']) {
            unset($data['comment']);
        }
        if (isset($data['showPriority']) && '' === $data['showPriority']) {
            unset($data['showPriority']);
        }
        return $data;
    }

}
