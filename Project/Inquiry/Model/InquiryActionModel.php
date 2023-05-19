<?php
declare(strict_types=1);

namespace Project\Inquiry\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Inquiry\Entity\InquiryAction;
use InvalidArgumentException;

class InquiryActionModel extends AbstractEntityModel implements
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
        $InquiryAction = new InquiryAction();
        $data = $this->filterValues($data);
        $InquiryAction->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $InquiryAction->setCreateDate($DateTime->format('Y-m-d'));
        $InquiryAction->setCreateTime($DateTime->format('H:i:s'));
        $InquiryAction->setCreateAdminId($this->getCreateAdminId());
        $InquiryAction->setUpdateDate($DateTime->format('Y-m-d'));
        $InquiryAction->setUpdateTime($DateTime->format('H:i:s'));
        $InquiryAction->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($InquiryAction);
        $this->getEntityManager()->flush();
        return $InquiryAction;
    }

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrInquiryAction)
    {
        if ($idOrInquiryAction instanceof InquiryAction) {
            return $idOrInquiryAction;
        }

        return $this->getRepository()->findOneBy([
            'inquiryActionId' => $idOrInquiryAction,
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
                'inquiryActionId' => 'ASC',
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
                'inquiryActionId' => 'ASC',
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
    public function update($idOrInquiryAction, $data = null) : EntityInterface
    {
        if (!$idOrInquiryAction instanceof EntityInterface) {
            $idOrInquiryAction = $this->get($idOrInquiryAction);
        }
        if (!$idOrInquiryAction instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: InquiryAction');
        }
        if ($data) {
            $data = $this->filterValues($data);
            $idOrInquiryAction->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrInquiryAction->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrInquiryAction->setUpdateTime($DateTime->format('H:i:s'));
        $idOrInquiryAction->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrInquiryAction);
        $this->getEntityManager()->flush();
        return $idOrInquiryAction;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrInquiryAction) : EntityInterface
    {
        $InquiryAction = $this->get($idOrInquiryAction);
        if (!$InquiryAction instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: InquiryAction');
        }
        $InquiryAction->setDeleteFlag(true);
        $this->getEntityManager()->merge($InquiryAction);
        $this->getEntityManager()->flush();
        return $InquiryAction;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrInquiryAction)
    {
        $InquiryAction = $this->get($idOrInquiryAction);
        if (!$InquiryAction instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: InquiryAction');
        }
        $this->getEntityManager()->remove($InquiryAction);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(InquiryAction::class);
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
            'action' => [
                0 => 'INQUIRYACTION_TYPE_OFF',
                1 => 'INQUIRYACTION_TYPE_ON',
            ],
            'deleteFlag' => [
                0 => 'INQUIRYACTION_DELETEFLAG_OFF',
                1 => 'INQUIRYACTION_DELETEFLAG_ON',
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
            'inquiryActionId' => 'INQUIRYACTION_INQUIRYACTIONID',
            'action' => 'INQUIRYACTION_ACTION',
            'description' => 'INQUIRYACTION_DESCRIPTION',
            'showPriority' => 'INQUIRYACTION_SHOWPRIORITY',
            'createDate' => 'INQUIRYACTION_CREATEDATE',
            'createTime' => 'INQUIRYACTION_CREATETIME',
            'createAdminId' => 'INQUIRYACTION_CREATEADMINID',
            'updateDate' => 'INQUIRYACTION_UPDATEDATE',
            'updateTime' => 'INQUIRYACTION_UPDATETIME',
            'updateAdminId' => 'INQUIRYACTION_UPDATEADMINID',
            'deleteFlag' => 'INQUIRYACTION_DELETEFLAG',
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
        if (isset($data['inquiryActionId'])) {
            unset($data['inquiryActionId']);
        }
        // 空白文字列フィルター
        if (isset($data['action']) && '' === $data['action']) {
            unset($data['action']);
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
