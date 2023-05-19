<?php
declare(strict_types=1);

namespace Project\Inquiry\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Inquiry\Entity\Inquiry;
use Project\Inquiry\Model\InquiryTypeModel;
use Project\Inquiry\Model\InquiryActionModel;
use Project\AdminUser\Model\AdminModel;
use InvalidArgumentException;

class InquiryModel extends AbstractEntityModel implements
    EntityManagerAwareInterface,
    ConfigManagerAwareInterface,
    CryptManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;

    private $Repository;
    protected static $InquiryTypeObjects;
    protected static $InquiryActionObjects;
    protected static $AdminObjects;

    /**
     * Entityを作成
     *
     * @param array $data
     * @return EntityInterface
     */
    public function create($data) : EntityInterface
    {
        $Inquiry = new Inquiry();
        $data = $this->filterValues($data);
        if (isset($data['InquiryType'])) {
            $InquiryTypeModel = $this->getObjectManager()->get(InquiryTypeModel::class);
            $data['InquiryType'] = $InquiryTypeModel->get($data['InquiryType']);
        }
        if (isset($data['InquiryAction'])) {
            $InquiryActionModel = $this->getObjectManager()->get(InquiryActionModel::class);
            $data['InquiryAction'] = $InquiryActionModel->get($data['InquiryAction']);
        }
        $Inquiry->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $Inquiry->setCreateDate($DateTime->format('Y-m-d'));
        $Inquiry->setCreateTime($DateTime->format('H:i:s'));
        $Inquiry->setCreateAdminId($this->getCreateAdminId());
        $Inquiry->setUpdateDate($DateTime->format('Y-m-d'));
        $Inquiry->setUpdateTime($DateTime->format('H:i:s'));
        $Inquiry->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($Inquiry);
        $this->getEntityManager()->flush();
        return $Inquiry;
    }

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrInquiry)
    {
        if ($idOrInquiry instanceof Inquiry) {
            return $idOrInquiry;
        }

        return $this->getRepository()->findOneBy([
            'inquiryId' => $idOrInquiry,
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
                'inquiryId' => 'ASC',
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
                'inquiryId' => 'ASC',
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
    public function update($idOrInquiry, $data = null) : EntityInterface
    {
        if (!$idOrInquiry instanceof EntityInterface) {
            $idOrInquiry = $this->get($idOrInquiry);
        }
        if (!$idOrInquiry instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: Inquiry');
        }
        if ($data) {
            $data = $this->filterValues($data);
            if (isset($data['InquiryType'])) {
                $InquiryTypeModel = $this->getObjectManager()->get(InquiryTypeModel::class);
                $data['InquiryType'] = $InquiryTypeModel->get($data['InquiryType']);
            }
            if (isset($data['InquiryAction'])) {
                $InquiryActionModel = $this->getObjectManager()->get(InquiryActionModel::class);
                $data['InquiryAction'] = $InquiryActionModel->get($data['InquiryAction']);
            }
            $idOrInquiry->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrInquiry->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrInquiry->setUpdateTime($DateTime->format('H:i:s'));
        $idOrInquiry->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrInquiry);
        $this->getEntityManager()->flush();
        return $idOrInquiry;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrInquiry) : EntityInterface
    {
        $Inquiry = $this->get($idOrInquiry);
        if (!$Inquiry instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: Inquiry');
        }
        $Inquiry->setDeleteFlag(true);
        $this->getEntityManager()->merge($Inquiry);
        $this->getEntityManager()->flush();
        return $Inquiry;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrInquiry)
    {
        $Inquiry = $this->get($idOrInquiry);
        if (!$Inquiry instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: Inquiry');
        }
        $this->getEntityManager()->remove($Inquiry);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(Inquiry::class);
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
            'processStatus' => [
                1 => 'INQUIRY_STATUS_CREATED',
                2 => 'INQUIRY_STATUS_INPROGRESS',
                3 => 'INQUIRY_STATUS_PROCESSED',
                4 => 'INQUIRY_STATUS_COMPLETE',
                5 => 'INQUIRY_STATUS_KEEP',
                6 => 'INQUIRY_STATUS_NONEED'
            ],
            'processPriority' => [
                0 => 'INQUIRY_PRIORITY_LOW',
                1 => 'INQUIRY_PRIORITY_MIDDLE',
                2 => 'INQUIRY_PRIORITY_HIGH'
            ],
            'deleteFlag' => [
                0 => 'INQUIRY_DELETEFLAG_OFF',
                1 => 'INQUIRY_DELETEFLAG_ON',
            ],
            'displaySort' => [
                0 => 'INQUIRY_SORT_NOMAL',
                1 => 'INQUIRY_SORT_LOW_PRIORITY',
                2 => 'INQUIRY_SORT_HIGH_PRIORITY',
                3 => 'INQUIRY_SORT_NEAR_DEADLINE',
                4 =>'INQUIRY_SORT_FAR_DEADLINE'
            ]
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
            'inquiryId' => 'INQUIRY_INQUIRYID',
            'subject' => 'INQUIRY_SUBJECT',
            'body' => 'INQUIRY_BODY',
            'name' => 'INQUIRY_NAME',
            'nameSei' => 'INQUIRY_NAMESEI',
            'nameMei' => 'INQUIRY_NAMEMEI',
            'kanaSei' => 'INQUIRY_KANASEI',
            'kanaMei' => 'INQUIRY_KANAMEI',
            'rentalNo' => 'INQUIRY_RENTALNO',
            'paypalAccount' => 'INQUIRY_PAYPALACCOUNT',
            'email' => 'INQUIRY_EMAIL',
            'phone' => 'INQUIRY_PHONE',
            'mCustomerId' => 'INQUIRY_MCUSTOMERID',
            'mAdminId' => 'INQUIRY_MADMINID',
            'processStatus' => 'INQUIRY_STATUS',
            'processDeadline' => 'INQUIRY_PROCESSDEADLINE',
            'processPriority' => 'INQUIRY_PROCESSPRIORITY',
            'processComment' => 'INQUIRY_PROCESSCOMMENT',
            'inquiryDateTime' => 'INQUIRY_DATETIME',
            'createDate' => 'INQUIRY_CREATEDATE',
            'createTime' => 'INQUIRY_CREATETIME',
            'createAdminId' => 'INQUIRY_CREATEADMINID',
            'updateDate' => 'INQUIRY_UPDATEDATE',
            'updateTime' => 'INQUIRY_UPDATETIME',
            'updateAdminId' => 'INQUIRY_UPDATEADMINID',
            'deleteFlag' => 'INQUIRY_DELETEFLAG',
            'inquiryType' => 'INQUIRY_INQUIRYTYPE',
            'inquiryAction' => 'INQUIRY_INQUIRYACTION',
            'keyword' => 'INQUIRY_KEYWORD',
            'myTask' => 'INQUIRY_MYTASK_FLG',

            'frontName' => 'FRONT_INQUIRY_NAME',
            'frontRentalNo' => 'FRONT_INQUIRY_RENTALNO',
            'frontEmail' => 'FRONT_INQUIRY_EMAIL',
            'frontPhone' => 'FRONT_INQUIRY_PHONE',
            'frontInquiryType' => 'FRONT_INQUIRY_INQUIRYTYPE',
            'frontInquiryAction' => 'FRONT_INQUIRY_INQUIRYACTION',
            'frontBody' => 'FRONT_INQUIRY_BODY',

            'frontNamePlaceholder' => 'FRONT_INQUIRY_NAME_PLACEHOLDER',
            'frontRentalNoPlaceholder' => 'FRONT_INQUIRY_RENTALNO_PLACEHOLDER',
            'frontEmailPlaceholder' => 'FRONT_EMAIL_PLACEHOLDER',
            'frontLoginPlaceholder' => 'FRONT_LOGIN_PLACEHOLDER',
            'frontPhonePlaceholder' => 'FRONT_INQUIRY_PHONE_PLACEHOLDER',
            'frontInquiryTypeEmptyOption' => 'FRONT_INQUIRY_INQUIRYTYPE_EMPTY_OPTION',
            'frontInquiryActionEmptyOption' => 'FRONT_INQUIRY_INQUIRYACTION_EMPTY_OPTION',
            'frontBodyPlaceholder' => 'FRONT_INQUIRY_BODY_PLACEHOLDER',

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
        if (isset($data['inquiryId'])) {
            unset($data['inquiryId']);
        }
        // 空白文字列フィルター
        if (isset($data['body']) && '' === $data['body']) {
            unset($data['body']);
        }
        if (isset($data['rentalNo']) && '' === $data['rentalNo']) {
            unset($data['rentalNo']);
        }
        if (isset($data['paypalAccount']) && '' === $data['paypalAccount']) {
            unset($data['paypalAccount']);
        }
        if (isset($data['email']) && '' === $data['email']) {
            unset($data['email']);
        }
        if (isset($data['phone']) && '' === $data['phone']) {
            unset($data['phone']);
        }
        if (isset($data['mCustomerId']) && '' === $data['mCustomerId']) {
            unset($data['mCustomerId']);
        }
        if (isset($data['mAdminId']) && '' === $data['mAdminId']) {
            unset($data['mAdminId']);
        }
        if (isset($data['processStatus']) && '' === $data['processStatus']) {
            unset($data['processStatus']);
        }
        if (isset($data['processDeadline']) && '' === $data['processDeadline']) {
            unset($data['processDeadline']);
        }
        if (isset($data['processPriority']) && '' === $data['processPriority']) {
            unset($data['processPriority']);
        }
        if (isset($data['InquiryType']) && '' === $data['InquiryType']) {
            unset($data['InquiryType']);
        }
        if (isset($data['InquiryAction']) && '' === $data['InquiryAction']) {
            unset($data['InquiryAction']);
        }
        return $data;
    }

    public static function getInquiryTypeObjects($label = null, array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        if (null === self::$InquiryTypeObjects) {
            self::$InquiryTypeObjects = [];
            $InquiryTypeModel = ObjectManager::getSingleton()->get(InquiryTypeModel::class);
            // 検索条件の拡張や調整はここ

            self::$InquiryTypeObjects = $InquiryTypeModel->getList($criteria, $orderBy, $limit, $offset);
        }
        if (null === $label) {
            $label = '';
        }
        $valueOptions = [];
        foreach (self::$InquiryTypeObjects as $InquiryType) {
            $id                = $InquiryType->getInquiryTypeId();
            $valueOptions[$id] = $InquiryType->getType();
        }
        if (isset($valueOptions[$label])) {
            return $valueOptions[$label];
        }

        return $valueOptions;
    }

    public static function getInquiryTypeObjectsHaystack()
    {
        $hayStack = [];
        if (null === self::$InquiryTypeObjects) {
            self::getInquiryTypeObjects();
        }
        foreach (self::$InquiryTypeObjects as $InquiryType) {
            $hayStack[] = $InquiryType->getInquiryTypeId();
        }
        return $hayStack;
    }

    public static function getAdminObjects($label = null, array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        if (null === self::$AdminObjects) {
            self::$AdminObjects = [];
            $AdminModel = ObjectManager::getSingleton()->get(AdminModel::class);
            // 検索条件の拡張や調整はここ

            self::$AdminObjects = $AdminModel->getList($criteria, $orderBy, $limit, $offset);
        }
        if (null === $label) {
            $label = '';
        }
        $valueOptions = [];
        foreach (self::$AdminObjects as $Admin) {
            $id                = $Admin->getAdminId();
            $valueOptions[$id] = $Admin->getAdminName();
        }
        if (isset($valueOptions[$label])) {
            return $valueOptions[$label];
        }

        return $valueOptions;
    }

    public static function getAdminObjectsHaystack()
    {
        $hayStack = [];
        if (null === self::$AdminObjects) {
            self::getAdminObjects();
        }
        foreach (self::$AdminObjects as $Admin) {
            $hayStack[] = $Admin->getAdminId();
        }
        return $hayStack;
    }

    public static function getInquiryActionObjects($label = null, array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        if (null === self::$InquiryActionObjects) {
            self::$InquiryActionObjects = [];
            $InquiryActionModel = ObjectManager::getSingleton()->get(InquiryActionModel::class);
            // 検索条件の拡張や調整はここ

            self::$InquiryActionObjects = $InquiryActionModel->getList($criteria, $orderBy, $limit, $offset);
        }
        if (null === $label) {
            $label = '';
        }
        $valueOptions = [];
        foreach (self::$InquiryActionObjects as $InquiryAction) {
            $id                = $InquiryAction->getInquiryActionId();
            $valueOptions[$id] = $InquiryAction->getAction();
        }
        if (isset($valueOptions[$label])) {
            return $valueOptions[$label];
        }

        return $valueOptions;
    }

    public static function getInquiryActionObjectsHaystack()
    {
        $hayStack = [];
        if (null === self::$InquiryActionObjects) {
            self::getInquiryActionObjects();
        }
        foreach (self::$InquiryActionObjects as $InquiryAction) {
            $hayStack[] = $InquiryAction->getInquiryActionId();
        }
        return $hayStack;
    }
}
