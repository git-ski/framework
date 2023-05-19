<?php
declare(strict_types=1);

namespace Project\Customer\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Customer\Entity\CustomerReminder;
use Project\Customer\Model\CustomerModel;
use InvalidArgumentException;

class CustomerReminderModel extends AbstractEntityModel implements
    EntityManagerAwareInterface,
    ConfigManagerAwareInterface,
    CryptManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;

    private $Repository;
    private static $CustomerObjects;

    /**
     * Entityを作成
     *
     * @param array $data
     * @return EntityInterface
     */
    public function create($data) : EntityInterface
    {
        $CustomerReminder = new CustomerReminder();
        $data = $this->filterValues($data);
        if (isset($data['Customer'])) {
            $CustomerModel = $this->getObjectManager()->get(CustomerModel::class);
            $data['Customer'] = $CustomerModel->get($data['Customer']);
        }
        $CustomerReminder->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $CustomerReminder->setCreateDate($DateTime->format('Y-m-d'));
        $CustomerReminder->setCreateTime($DateTime->format('H:i:s'));
        $CustomerReminder->setCreateAdminId($this->getCreateAdminId());
        $CustomerReminder->setUpdateDate($DateTime->format('Y-m-d'));
        $CustomerReminder->setUpdateTime($DateTime->format('H:i:s'));
        $CustomerReminder->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($CustomerReminder);
        $this->getEntityManager()->flush();
        return $CustomerReminder;
    }

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrCustomerReminder)
    {
        if ($idOrCustomerReminder instanceof CustomerReminder) {
            return $idOrCustomerReminder;
        }

        return $this->getRepository()->findOneBy([
            'customerReminderId' => $idOrCustomerReminder,
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
                'customerReminderId' => 'ASC',
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
                'customerReminderId' => 'ASC',
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
    public function update($idOrCustomerReminder, $data = null) : EntityInterface
    {
        if (!$idOrCustomerReminder instanceof EntityInterface) {
            $idOrCustomerReminder = $this->get($idOrCustomerReminder);
        }
        if (!$idOrCustomerReminder instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: CustomerReminder');
        }
        if ($data) {
            $data = $this->filterValues($data);
            if (isset($data['Customer'])) {
                $CustomerModel = $this->getObjectManager()->get(CustomerModel::class);
                $data['Customer'] = $CustomerModel->get($data['Customer']);
            }
            $idOrCustomerReminder->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrCustomerReminder->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrCustomerReminder->setUpdateTime($DateTime->format('H:i:s'));
        $idOrCustomerReminder->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrCustomerReminder);
        $this->getEntityManager()->flush();
        return $idOrCustomerReminder;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrCustomerReminder) : EntityInterface
    {
        if (!$idOrCustomerReminder instanceof EntityInterface) {
            $idOrCustomerReminder = $this->get($idOrCustomerReminder);
        }
        if (!$idOrCustomerReminder instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: CustomerReminder');
        }
        $idOrCustomerReminder->setDeleteFlag(true);
        $this->getEntityManager()->merge($idOrCustomerReminder);
        $this->getEntityManager()->flush();
        return $idOrCustomerReminder;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrCustomerReminder)
    {
        if (!$idOrCustomerReminder instanceof EntityInterface) {
            $idOrCustomerReminder = $this->get($idOrCustomerReminder);
        }
        if (!$idOrCustomerReminder instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: CustomerReminder');
        }
        $this->getEntityManager()->remove($idOrCustomerReminder);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(CustomerReminder::class);
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
            'useFlag' => [
                0 => 'CUSTOMERREMINDER_USEFLAG_OFF',
                1 => 'CUSTOMERREMINDER_USEFLAG_ON',
            ],
            'deleteFlag' => [
                0 => 'CUSTOMERREMINDER_DELETEFLAG_OFF',
                1 => 'CUSTOMERREMINDER_DELETEFLAG_ON',
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
            'customerReminderId' => 'CUSTOMERREMINDER_CUSTOMERREMINDERID',
            'urlHashKey' => 'CUSTOMERREMINDER_URLHASHKEY',
            'frontVerifyHashKey' => 'FRONT_CUSTOMER_REMINDER_VERIFYHASHKEY',
            'frontVerifyHashKeyPlaceholder' => 'FRONT_CUSTOMER_REMINDER_VERIFYHASHKEY_PLACEHOLDER',
            'frontRecoveryCustomerPassword' => 'FRONT_RECOVERY_CUSTOMER_PASSWORD',
            'frontRecoveryCustomerPasswordPlaceholder' => 'FRONT_RECOVERY_CUSTOMER_PASSWORD_PLACEHOLDER',
            'frontRecoveryCustomerPasswordConfirm' => 'FRONT_RECOVERY_CUSTOMER_PASSWORD_CONFIRM',
            'frontRecoveryCustomerPasswordConfirmPlaceholder' => 'FRONT_RECOVERY_CUSTOMER_PASSWORD_CONFIRM_PLACEHOLDER',
            'useFlag' => 'CUSTOMERREMINDER_USEFLAG',
            'createDate' => 'CUSTOMERREMINDER_CREATEDATE',
            'createTime' => 'CUSTOMERREMINDER_CREATETIME',
            'createAdminId' => 'CUSTOMERREMINDER_CREATEADMINID',
            'updateDate' => 'CUSTOMERREMINDER_UPDATEDATE',
            'updateTime' => 'CUSTOMERREMINDER_UPDATETIME',
            'updateAdminId' => 'CUSTOMERREMINDER_UPDATEADMINID',
            'deleteFlag' => 'CUSTOMERREMINDER_DELETEFLAG',
            'Customer' => 'CUSTOMERREMINDER_CUSTOMER',
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
        if (isset($data['customerReminderId'])) {
            unset($data['customerReminderId']);
        }
        // 空白文字列フィルター
        if (isset($data['urlHashKey']) && '' === $data['urlHashKey']) {
            unset($data['urlHashKey']);
        }
        if (isset($data['verifyHashKey']) && '' === $data['verifyHashKey']) {
            unset($data['verifyHashKey']);
        }
        if (isset($data['useFlag']) && '' === $data['useFlag']) {
            unset($data['useFlag']);
        }
        if (isset($data['Customer']) && '' === $data['Customer']) {
            unset($data['Customer']);
        }
        return $data;
    }

    public static function getCustomerObjects($label = null, array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        if (null === self::$CustomerObjects) {
            self::$CustomerObjects = [];
            $CustomerModel = ObjectManager::getSingleton()->get(CustomerModel::class);
            // ここで検索条件を必ず確認し、調整してください

            self::$CustomerObjects = $CustomerModel->getList($criteria, $orderBy, $limit, $offset);
        }
        if (null === $label) {
            $label = '';
        }
        $valueOptions = [];
        foreach (self::$CustomerObjects as $Customer) {
            $id                = $Customer->getCustomerId();
            $valueOptions[$id] = join(' ', [$Customer->getNameSei(), $Customer->getNameMei()]);
        }
        return $valueOptions;
    }

    public static function getCustomerObjectsHaystack()
    {
        $hayStack = [];
        if (null === self::$CustomerObjects) {
            self::getCustomerObjects();
        }
        foreach (self::$CustomerObjects as $Customer) {
            $hayStack[] = $Customer->getCustomerId();
        }
        return $hayStack;
    }
}
