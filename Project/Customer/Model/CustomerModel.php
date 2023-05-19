<?php
declare(strict_types=1);

namespace Project\Customer\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Customer\Entity\Customer;
use Project\Base\Model\CountryModel;
use Project\Base\Model\PrefectureModel;
use Project\Customer\Model\CustomerLModel;
use InvalidArgumentException;
use Generator;
use PDO;

class CustomerModel extends AbstractEntityModel implements
    EntityManagerAwareInterface,
    ConfigManagerAwareInterface,
    CryptManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;

    private $Repository;
    private static $CountryObjects;
    private static $PrefectureObjects;

    /**
     * Entityを作成
     *
     * @param array $data
     * @return EntityInterface
     */
    public function create($data) : EntityInterface
    {
        $Customer = new Customer();
        $data = $this->filterValues($data);
        $data['customerPassword'] = $this->getCryptManager()->getPasswordCrypt()->create($data['customerPassword']);
        if (isset($data['Country'])) {
            $CountryModel = $this->getObjectManager()->get(CountryModel::class);
            $data['Country'] = $CountryModel->get($data['Country']);
        }
        if (isset($data['Prefecture'])) {
            $PrefectureModel = $this->getObjectManager()->get(PrefectureModel::class);
            $data['Prefecture'] = $PrefectureModel->get($data['Prefecture']);
        }
        $Customer->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $Customer->setCreateDate($DateTime->format('Y-m-d'));
        $Customer->setCreateTime($DateTime->format('H:i:s'));
        $Customer->setCreateAdminId($this->getCreateAdminId());
        $Customer->setUpdateDate($DateTime->format('Y-m-d'));
        $Customer->setUpdateTime($DateTime->format('H:i:s'));
        $Customer->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($Customer);
        $this->getEntityManager()->flush();
        return $Customer;
    }

    /**
     * DoctrineのBulk Insertを使って、大量データのinsertを効率化する
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/batch-processing.html#batch-processing
     *
     * @param Generator $dataGenerator
     * @param integer $batchSize
     * @return CustomerModel
     */
    public function bulkCreate($dataList, $batchSize = 1000)
    {
        $index = 0;
        foreach ($dataList as $data) {
            ++$index;
            $Customer = new Customer();
            $data = $this->filterValues($data);
            // $data['customerPassword'] = $this->getCryptManager()->getPasswordCrypt()->create($data['customerPassword']);
            if (isset($data['Country'])) {
                $CountryModel = $this->getObjectManager()->get(CountryModel::class);
                $data['Country'] = $CountryModel->get($data['Country']);
            }
            if (isset($data['Prefecture'])) {
                $PrefectureModel = $this->getObjectManager()->get(PrefectureModel::class);
                $data['Prefecture'] = $PrefectureModel->get($data['Prefecture']);
            }
            $Customer->fromArray($data);
            $DateTime = $this->getDateTimeForEntity();
            $Customer->setTempPasswordFlag(self::getPropertyValue('tempPasswordFlag', 'CUSTOMER_TEMPPASSWORDFLAG_OFF'));
            $Customer->setCreateDate($DateTime->format('Y-m-d'));
            $Customer->setCreateTime($DateTime->format('H:i:s'));
            $Customer->setCreateAdminId($this->getCreateAdminId());
            $Customer->setUpdateDate($DateTime->format('Y-m-d'));
            $Customer->setUpdateTime($DateTime->format('H:i:s'));
            $Customer->setUpdateAdminId($this->getUpdateAdminId());
            $this->getEntityManager()->persist($Customer);
            if (($index % $batchSize) === 0) {
                $this->getEntityManager()->flush();
                $this->getEntityManager()->clear();
            }
        }
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
        return $this;
    }

    public function bulkUpdate(Generator $dataGenerator, $batchSize = 1000)
    {
        $dql = 'UPDATE Project\Customer\Entity\Customer c SET c.nameMei = :nameMei,
                    c.nameSei = :nameSei,
                    c.kanaSei = :kanaSei,
                    c.kanaMei = :kanaMei,
                    c.customerPassword = :customerPassword,
                    c.tempPasswordFlag = :tempPasswordFlag,
                    c.Prefecture = :Prefecture,
                    c.zipCd = :zipCd,
                    c.address01 = :address01,
                    c.address02 = :address02,
                    c.address03 = :address03,
                    c.email = :email,
                    c.phone = :phone,
                    c.birthDate = :birthDate,
                    c.sexTypeId = :sexTypeId,
                    c.mailmagazineReceiveFlag = :mailmagazineReceiveFlag,
                    c.memberRegisterDate = :memberRegisterDate,
                    c.memberWithdrawDate = :memberWithdrawDate,
                    c.updateDate = :updateDate,
                    c.updateTime = :updateTime,
                    c.updateAdminId = :updateAdminId
                    WHERE c.customerId = :customerId';
        $query = $this->getEntityManager()->createQuery($dql);

        $CustomerLModel = $this->getObjectManager()->get(CustomerLModel::class);
        $PrefectureModel = $this->getObjectManager()->get(PrefectureModel::class);

        $index = 0;
        foreach ($dataGenerator as $data) {
            ++$index;
            $customerId = $data['customerId'];
            $data = $this->filterValues($data);
            $data['customerPassword'] = $this->getCryptManager()->getPasswordCrypt()->create($data['customerPassword']);

            if (isset($data['Prefecture'])) {
                $data['Prefecture'] = $PrefectureModel->get($data['Prefecture']);
            }
            $query->setParameter('customerId', $customerId);
            $query->setParameter('nameMei', $data['nameMei']);
            $query->setParameter('nameSei', $data['nameSei']);
            $query->setParameter('kanaSei', $data['kanaSei']);
            $query->setParameter('kanaMei', $data['kanaMei']);
            $query->setParameter('customerPassword', $this->getCryptManager()->getPasswordCrypt()->create($data['customerPassword']));
            $query->setParameter('tempPasswordFlag', $data['tempPasswordFlag']);
            $query->setParameter('Prefecture', $data['Prefecture']);
            $query->setParameter('zipCd', $data['zipCd']);
            $query->setParameter('address01', $data['address01']);
            $query->setParameter('address02', $data['address02']);
            $query->setParameter('address03', $data['address03']);
            $query->setParameter('email', $data['email']);
            $query->setParameter('phone', $data['phone']);
            $query->setParameter('birthDate', $data['birthDate']);
            $query->setParameter('sexTypeId', $data['sexTypeId']);
            $query->setParameter('mailmagazineReceiveFlag', $data['mailmagazineReceiveFlag']);
            $query->setParameter('memberRegisterDate', $data['memberRegisterDate']);
            $query->setParameter('memberWithdrawDate', $data['memberWithdrawDate']);

            $DateTime = $this->getDateTimeForEntity();
            $query->setParameter('updateDate', $DateTime->format('Y-m-d'));
            $query->setParameter('updateTime', $DateTime->format('H:i:s'));
            $query->setParameter('updateAdminId', $this->getUpdateAdminId());

            $result = $query->getResult();

            $Customer = $this->get($customerId);
            // 履歴を残す
            $logData = $data + [
                'Customer'   => $Customer,
                'logType' => CustomerLModel::getPropertyValue('logType', 'CUSTOMERL_LOGTYPE_BATCHUPDATE')
            ];
            $CustomerLModel->create($logData);
        }
        return $this;
    }
    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrCustomer)
    {
        if ($idOrCustomer instanceof Customer) {
            return $idOrCustomer;
        }

        return $this->getRepository()->findOneBy([
            'customerId' => $idOrCustomer,
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
                'customerId' => 'ASC',
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
                'customerId' => 'ASC',
            ];
        }
        return $this->getRepository()->findOneBy($criteria, $orderBy);
    }

    public function getCustomerBy(array $criteria, array $orderBy = null)
    {
        $qb = $this->getRepository()->createQueryBuilder('c');
        $qb->where('c.deleteFlag = :deleteFlag');
        $qb->andWhere('c.memberWithdrawDate IS NULL');
        $qb->andWhere('c.login = :login');
        $qb->andWhere('c.email = :email');
        $qb->setParameters([
            'deleteFlag' => self::getPropertyValue('deleteFlag', 'CUSTOMER_DELETEFLAG_OFF'),
            'login' => $criteria['login'],
            'email' => $criteria['email']
        ]);
        if (empty($orderBy)) {
            $orderBy = [
                'customerId' => 'ASC',
            ];
        }
        $qb->setMaxResults(1);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * Entityを更新する
     *
     * @param integer|EntityInterface $idOrEntity
     * @param array                   $data
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function update($idOrCustomer, $data = null) : EntityInterface
    {
        if (!$idOrCustomer instanceof EntityInterface) {
            $idOrCustomer = $this->get($idOrCustomer);
        }
        if (!$idOrCustomer instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: Customer');
        }
        if ($data) {
            $data = $this->filterValues($data);
            if (isset($data['customerPassword'])) {
                $data['customerPassword'] = $this->getCryptManager()->getPasswordCrypt()->create($data['customerPassword']);
            }
            if (isset($data['Country'])) {
                $CountryModel = $this->getObjectManager()->get(CountryModel::class);
                $data['Country'] = $CountryModel->get($data['Country']);
            }
            if (isset($data['Prefecture'])) {
                $PrefectureModel = $this->getObjectManager()->get(PrefectureModel::class);
                $data['Prefecture'] = $PrefectureModel->get($data['Prefecture']);
            }
            $idOrCustomer->fromArray($data);
            if (isset($data['memberWithdrawDate']) && '' === $data['memberWithdrawDate']) {
                $data['memberWithdrawDate'] = null;
                $idOrCustomer->setMemberWithdrawDate($data['memberWithdrawDate']);
            }
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrCustomer->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrCustomer->setUpdateTime($DateTime->format('H:i:s'));
        $idOrCustomer->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrCustomer);
        $this->getEntityManager()->flush();
        return $idOrCustomer;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrCustomer) : EntityInterface
    {
        $Customer = $this->get($idOrCustomer);
        if (!$Customer instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: Customer');
        }
        $Customer->setDeleteFlag(true);
        $this->getEntityManager()->merge($Customer);
        $this->getEntityManager()->flush();
        return $Customer;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrCustomer)
    {
        $Customer = $this->get($idOrCustomer);
        if (!$Customer instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: Customer');
        }
        $this->getEntityManager()->remove($Customer);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(Customer::class);
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
            'tempPasswordFlag' => [
                0 => 'CUSTOMER_TEMPPASSWORDFLAG_OFF',
                1 => 'CUSTOMER_TEMPPASSWORDFLAG_ON',
            ],
            'defaultLanguage' => [
                1 => 'CUSTOMER_DEFAULTLANGUAGE_JA',
                2 => 'CUSTOMER_DEFAULTLANGUAGE_EN',
            ],
            'deleteFlag' => [
                0 => 'CUSTOMER_DELETEFLAG_OFF',
                1 => 'CUSTOMER_DELETEFLAG_ON',
            ],
            'mailmagazineReceiveFlag' => [
                0 => 'CUSTOMER_MAILMAGAZINE_RECEIVEFLAG_OFF',
                1 => 'CUSTOMER_MAILMAGAZINE_RECEIVEFLAG_ON'
            ],
            'mailmagazineReceiveFlagFront' => [
                1 => 'CUSTOMER_MAILMAGAZINE_RECEIVEFLAG_FRONT'
            ],
            'sendMailToCustomer' => [
                1 => 'CUSTOMER_SENDMAIL_TO_CUSTOMER'
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
            'customerId' => 'CUSTOMER_CUSTOMERID',
            'customerNo' => 'CUSTOMER_CUSTOMERNO',
            'login' => 'CUSTOMER_LOGIN',
            'nameSei' => 'CUSTOMER_NAMESEI',
            'nameMei' => 'CUSTOMER_NAMEMEI',
            'kanaSei' => 'CUSTOMER_KANASEI',
            'kanaMei' => 'CUSTOMER_KANAMEI',
            'customerPassword' => 'CUSTOMER_CUSTOMERPASSWORD',
            'customerPasswordConfirm' => 'CUSTOMER_CUSTOMERPASSWORDCONFIRM',
            'tempPasswordFlag' => 'CUSTOMER_TEMPPASSWORDFLAG',
            'zipCd' => 'CUSTOMER_ZIPCD',
            'address01' => 'CUSTOMER_ADDRESS01',
            'address02' => 'CUSTOMER_ADDRESS02',
            'address03' => 'CUSTOMER_ADDRESS03',
            'email' => 'CUSTOMER_EMAIL',
            'phone' => 'CUSTOMER_PHONE',
            'birthDate' => 'CUSTOMER_BIRTHDATE',
            'sexTypeId' => 'CUSTOMER_SEXTYPEID',
            'mailmagazineReceiveFlag'   => 'CUSTOMER_MAILMAGAZINE_RECEIVEFLAG',
            'memberRegisterDate' => 'CUSTOMER_MEMBERREGISTERDATE',
            'memberWithdrawDate' => 'CUSTOMER_MEMBERWITHDRAWDATE',
            'withdrawReason' => 'CUSTOMER_WITHDRAWREASON',
            'withdrawNote' => 'CUSTOMER_WITHDRAWNOTE',
            'lastLogintDatetime' => 'CUSTOMER_LASTLOGINTDATETIME',
            'defaultLanguage' => 'CUSTOMER_DEFAULTLANGUAGE',
            'sendMailToCustomer' => 'CUSTOMER_SENDMAIL',
            'createDate' => 'CUSTOMER_CREATEDATE',
            'createTime' => 'CUSTOMER_CREATETIME',
            'createAdminId' => 'CUSTOMER_CREATEADMINID',
            'updateDate' => 'CUSTOMER_UPDATEDATE',
            'updateTime' => 'CUSTOMER_UPDATETIME',
            'updateAdminId' => 'CUSTOMER_UPDATEADMINID',
            'deleteFlag' => 'CUSTOMER_DELETEFLAG',
            'Country' => 'CUSTOMER_COUNTRY',
            'Prefecture' => 'CUSTOMER_PREFECTURE',

            'frontLogin' => 'FRONT_CUSTOMER_LOGIN',
            'frontCustomerPassword' => 'FRONT_CUSTOMER_CUSTOMERPASSWORD',
            'frontCustomerPasswordOld' => 'FRONT_CUSTOMER_CUSTOMERPASSWORD_OLD',
            'frontCustomerPasswordNew' => 'FRONT_CUSTOMER_CUSTOMERPASSWORD_NEW',
            'frontCustomerPasswordNewConfirm' => 'FRONT_CUSTOMER_CUSTOMERPASSWORD_NEW_CONFIRM',

            'frontCustomerNameSei' => 'FRONT_CUSTOMER_NAMESEI',
            'frontCustomerNameMei' => 'FRONT_CUSTOMER_NAMEMEI',
            'frontCustomerKanaSei' => 'FRONT_CUSTOMER_KANASEI',
            'frontCustomerKanaMei' => 'FRONT_CUSTOMER_KANAMEI',
            'frontCustomerZipCd' => 'FRONT_CUSTOMER_ZIPCD',
            'frontCustomerPrefecture' => 'FRONT_CUSTOMER_PREFECTURE',
            'frontCustomerAddress01' => 'FRONT_CUSTOMER_ADDRESS01',
            'frontCustomerAddress02' => 'FRONT_CUSTOMER_ADDRESS02',
            'frontCustomerAddress03' => 'FRONT_CUSTOMER_ADDRESS03',
            'frontCustomerCountry' => 'FRONT_CUSTOMER_COUNTRY',
            'frontCustomerPhone' => 'FRONT_CUSTOMER_PHONE',
            'frontCustomerBirthDate' => 'FRONT_CUSTOMER_BIRTHDATE',
            'frontBirthDateYear' => 'FRONT_BIRTHDATE_YEAR',
            'frontBirthDateMonth' => 'FRONT_BIRTHDATE_MONTH',
            'frontBirthDateDay' => 'FRONT_BIRTHDATE_DAY',
            'frontEmail' => 'FRONT_CUSTOMER_EMAIL',

            'frontCustomerPasswordConfirm' => 'FRONT_CUSTOMER_PASSWORD_CONFIRM',
            'frontCustomerKanaSeiConfirm' => 'FRONT_CUSTOMER_KANASEI_CONFIRM',
            'frontCustomerKanaMeiConfirm' => 'FRONT_CUSTOMER_KANAMEI_CONFIRM',
            'frontCustomerZipCdConfirm' => 'FRONT_CUSTOMER_ZIPCD_CONFIRM',

            'frontCustomerNameSeiPlaceholder' => 'FRONT_CUSTOMER_NAMESEI_PLACEHOLDER',
            'frontCustomerNameMeiPlaceholder' => 'FRONT_CUSTOMER_NAMEMEI_PLACEHOLDER',
            'frontCustomerKanaSeiPlaceholder' => 'FRONT_CUSTOMER_KANASEI_PLACEHOLDER',
            'frontCustomerKanaMeiPlaceholder' => 'FRONT_CUSTOMER_KANAMEI_PLACEHOLDER',
            'frontCustomerPasswordConfirmPlaceholder' => 'FRONT_CUSTOMER_PASSWORD_CONFIRM_PLACEHOLDER',
            'frontEmailPlaceholder' => 'FRONT_EMAIL_PLACEHOLDER',
            'frontLoginPlaceholder' => 'FRONT_LOGIN_PLACEHOLDER',
            'frontCustomerZipCdPlaceholder'  => 'FRONT_CUSTOMER_ZIPCD_PLACEHOLDER',
            'frontCustomerAddress01Placeholder' => 'FRONT_CUSTOMER_ADDRESS01_PLACEHOLDER',
            'frontCustomerAddress02Placeholder' => 'FRONT_CUSTOMER_ADDRESS02_PLACEHOLDER',
            'frontCustomerAddress03Placeholder' => 'FRONT_CUSTOMER_ADDRESS03_PLACEHOLDER',
            'frontCustomerPhonePlaceholder' => 'FRONT_CUSTOMER_PHONE_PLACEHOLDER',
            'frontCustomerPrefecturePlaceholder' => 'FRONT_CUSTOMER_PREFECTURE_PLACEHOLDER',
            'frontCustomerCountryPlaceholder'  => 'FRONT_CUSTOMER_COUNTRY_PLACEHOLDER',
            'frontCustomerPasswordPlaceholder' => 'FRONT_CUSTOMER_CUSTOMERPASSWORD_PLACEHOLDER',
            'frontCustomerPasswordOldPlaceholder' => 'FRONT_CUSTOMER_CUSTOMERPASSWORD_OLD_PLACEHOLDER',
            'frontCustomerPasswordNewPlaceholder' => 'FRONT_CUSTOMER_CUSTOMERPASSWORD_NEW_PLACEHOLDER',
            'frontCustomerPasswordNewConfirmPlaceholder' => 'FRONT_CUSTOMER_CUSTOMERPASSWORD_NEW_CONFIRM_PLACEHOLDER',

            'frontCustomerWithdrawReason' => 'FRONT_CUSTOMER_WITHDRAW_REASON',
            'frontCustomerWithdrawNote' => 'FRONT_CUSTOMER_WITHDRAW_NOTE',

            'frontCustomerWithdrawReasonEmptyOption' => 'FRONT_CUSTOMER_WITHDRAW_REASON_EMPTY_OPTION',
            'frontCustomerWithdrawNotePlaceholder' => 'FRONT_CUSTOMER_WITHDRAW_NOTE_PLACEHOLDER',
            'frontCustomerWithdrawPasswordPlaceholder' => 'FRONT_CUSTOMER_WITHDRAW_CUSTOMERPASSWORD_PLACEHOLDER',

            'frontForgotEmailPlaceholder'=> 'FRONT_EMAIL_PLACEHOLDER',
            'frontForgotEmail' => 'FRONT_FORGOT_EMAIL',
            'frontReminderEmail' => 'FRONT_FORGOT_EMAIL',
            'frontReminderEmailPlaceholder' => 'FRONT_EMAIL_PLACEHOLDER',
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
        if (isset($data['customerId'])) {
            unset($data['customerId']);
        }
        // 空白文字列フィルター
        if (isset($data['login']) && '' === $data['login']) {
            unset($data['login']);
        }
        if (isset($data['customerPassword']) && '' === $data['customerPassword']) {
            unset($data['customerPassword']);
        }
        if (isset($data['tempPasswordFlag']) && '' === $data['tempPasswordFlag']) {
            unset($data['tempPasswordFlag']);
        }
        if (isset($data['email']) && '' === $data['email']) {
            unset($data['email']);
        }
        if (isset($data['birthDate']) && '' === $data['birthDate']) {
            unset($data['birthDate']);
        }
        if (isset($data['sexTypeId']) && '' === $data['sexTypeId']) {
            unset($data['sexTypeId']);
        }
        if (isset($data['mailmagazineReceiveFlag']) && '' === $data['mailmagazineReceiveFlag']) {
            unset($data['mailmagazineReceiveFlag']);
        }
        if (isset($data['memberRegisterDate']) && '' === $data['memberRegisterDate']) {
            unset($data['memberRegisterDate']);
        }
        if (isset($data['Country']) && '' === $data['Country']) {
            unset($data['Country']);
        }
        return $data;
    }

    public static function getCountryObjects($label = null, array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        if (null === self::$CountryObjects) {
            self::$CountryObjects = [];
            $CountryModel = ObjectManager::getSingleton()->get(CountryModel::class);
            // 検索条件の拡張や調整はここ

            self::$CountryObjects = $CountryModel->getList(
                [],
                [
                    'showPriority' => 'ASC',
                ],
                190,
                0
            );
        }
        if (null === $label) {
            $label = '';
        }
        $valueOptions = [];
        foreach (self::$CountryObjects as $Country) {
            $id                = $Country->getCountryId();
            $valueOptions[$id] = $Country->getCountryName();
        }
        return $valueOptions;
    }

    public static function getCountryObjectsHaystack()
    {
        $hayStack = [];
        if (null === self::$CountryObjects) {
            self::getCountryObjects();
        }
        foreach (self::$CountryObjects as $Country) {
            $hayStack[] = $Country->getCountryId();
        }
        return $hayStack;
    }

    public static function getPrefectureObjects($label = null, array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        if (null === $limit) {
            $limit = PHP_INT_MAX;
        }

        if (null === self::$PrefectureObjects) {
            self::$PrefectureObjects = [];
            $PrefectureModel = ObjectManager::getSingleton()->get(PrefectureModel::class);
            // 検索条件の拡張や調整はここ

            self::$PrefectureObjects = $PrefectureModel->getList($criteria, $orderBy, $limit, $offset);
        }
        if (null === $label) {
            $label = '';
        }
        $valueOptions = [];
        foreach (self::$PrefectureObjects as $Prefecture) {
            $id                = $Prefecture->getPrefectureId();
            $valueOptions[$id] = $Prefecture->getPrefectureName();
        }
        return $valueOptions;
    }

    public static function getPrefectureObjectsHaystack()
    {
        $hayStack = [];
        if (null === self::$PrefectureObjects) {
            self::getPrefectureObjects();
        }
        foreach (self::$PrefectureObjects as $Prefecture) {
            $hayStack[] = $Prefecture->getPrefectureId();
        }
        return $hayStack;
    }
}
