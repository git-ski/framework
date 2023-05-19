<?php
declare(strict_types=1);

namespace Project\Inquiry\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Inquiry\Entity\InquiryType;
use InvalidArgumentException;

class InquiryTypeModel extends AbstractEntityModel implements
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
        $InquiryType = new InquiryType();
        $data = $this->filterValues($data);
        $InquiryType->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $InquiryType->setCreateDate($DateTime->format('Y-m-d'));
        $InquiryType->setCreateTime($DateTime->format('H:i:s'));
        $InquiryType->setCreateAdminId($this->getCreateAdminId());
        $InquiryType->setUpdateDate($DateTime->format('Y-m-d'));
        $InquiryType->setUpdateTime($DateTime->format('H:i:s'));
        $InquiryType->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($InquiryType);
        $this->getEntityManager()->flush();
        return $InquiryType;
    }

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrInquiryType)
    {
        if ($idOrInquiryType instanceof InquiryType) {
            return $idOrInquiryType;
        }

        return $this->getRepository()->findOneBy([
            'inquiryTypeId' => $idOrInquiryType,
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
                'showPriority' => 'DESC',
                'inquiryTypeId' => 'ASC',
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
                'inquiryTypeId' => 'ASC',
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
    public function update($idOrInquiryType, $data = null) : EntityInterface
    {
        if (!$idOrInquiryType instanceof EntityInterface) {
            $idOrInquiryType = $this->get($idOrInquiryType);
        }
        if (!$idOrInquiryType instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: InquiryType');
        }
        if ($data) {
            $data = $this->filterValues($data);
            $idOrInquiryType->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrInquiryType->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrInquiryType->setUpdateTime($DateTime->format('H:i:s'));
        $idOrInquiryType->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrInquiryType);
        $this->getEntityManager()->flush();
        return $idOrInquiryType;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrInquiryType) : EntityInterface
    {
        $InquiryType = $this->get($idOrInquiryType);
        if (!$InquiryType instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: InquiryType');
        }
        $InquiryType->setDeleteFlag(true);
        $this->getEntityManager()->merge($InquiryType);
        $this->getEntityManager()->flush();
        return $InquiryType;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrInquiryType)
    {
        $InquiryType = $this->get($idOrInquiryType);
        if (!$InquiryType instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: InquiryType');
        }
        $this->getEntityManager()->remove($InquiryType);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(InquiryType::class);
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
                0 => 'INQUIRYTYPE_DELETEFLAG_OFF',
                1 => 'INQUIRYTYPE_DELETEFLAG_ON',
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
            'inquiryTypeId' => 'INQUIRYTYPE_INQUIRYTYPEID',
            'type' => 'INQUIRYTYPE_TYPE',
            'description' => 'INQUIRYTYPE_DESCRIPTION',
            'showPriority' => 'INQUIRYTYPE_SHOWPRIORITY',
            'createDate' => 'INQUIRYTYPE_CREATEDATE',
            'createTime' => 'INQUIRYTYPE_CREATETIME',
            'createAdminId' => 'INQUIRYTYPE_CREATEADMINID',
            'updateDate' => 'INQUIRYTYPE_UPDATEDATE',
            'updateTime' => 'INQUIRYTYPE_UPDATETIME',
            'updateAdminId' => 'INQUIRYTYPE_UPDATEADMINID',
            'deleteFlag' => 'INQUIRYTYPE_DELETEFLAG',
            'keyword' => 'INQUIRYTYPE_SEARCH_KEYWORD',
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
        if (isset($data['inquiryTypeId'])) {
            unset($data['inquiryTypeId']);
        }
        // 空白文字列フィルター
        if (isset($data['type']) && '' === $data['type']) {
            unset($data['type']);
        }
        if (isset($data['description']) && '' === $data['description']) {
            unset($data['description']);
        }
        if (isset($data['showPriority']) && '' === $data['showPriority']) {
            unset($data['showPriority']);
        }
        return $data;
    }
}
