<?php
declare(strict_types=1);
namespace Project\Customer\Model;
use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Customer\Entity\CustomerL;
use Project\Customer\Model\CustomerModel;
use InvalidArgumentException;
class CustomerLModel extends AbstractEntityModel implements
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
        $CustomerL = new CustomerL();
        $data = $this->filterValues($data);
        $data['customerPassword'] = $this->getCryptManager()->getPasswordCrypt()->create($data['customerPassword']);
        if (isset($data['Customer'])) {
            $CustomerModel = $this->getObjectManager()->get(CustomerModel::class);
            $data['Customer'] = $CustomerModel->get($data['Customer']);
        }
        $CustomerL->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $CustomerL->setCreateDate($DateTime->format('Y-m-d'));
        $CustomerL->setCreateTime($DateTime->format('H:i:s'));
        $CustomerL->setCreateAdminId($this->getCreateAdminId());
        $CustomerL->setUpdateDate($DateTime->format('Y-m-d'));
        $CustomerL->setUpdateTime($DateTime->format('H:i:s'));
        $CustomerL->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($CustomerL);
        $this->getEntityManager()->flush();
        return $CustomerL;
    }
    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrCustomerL)
    {
        if ($idOrCustomerL instanceof CustomerL) {
            return $idOrCustomerL;
        }
        return $this->getRepository()->findOneBy([
            'customerLId' => $idOrCustomerL,
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
                'customerLId' => 'ASC',
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
                'customerLId' => 'ASC',
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
    public function update($idOrCustomerL, $data = null) : EntityInterface
    {
        if (!$idOrCustomerL instanceof EntityInterface) {
            $idOrCustomerL = $this->get($idOrCustomerL);
        }
        if (!$idOrCustomerL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: CustomerL');
        }
        if ($data) {
            $data = $this->filterValues($data);
            if (isset($data['customerPassword'])) {
                $data['customerPassword'] = $this->getCryptManager()->getPasswordCrypt()->create($data['customerPassword']);
            }
            if (isset($data['Customer'])) {
                $CustomerModel = $this->getObjectManager()->get(CustomerModel::class);
                $data['Customer'] = $CustomerModel->get($data['Customer']);
            }
            $idOrCustomerL->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrCustomerL->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrCustomerL->setUpdateTime($DateTime->format('H:i:s'));
        $idOrCustomerL->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrCustomerL);
        $this->getEntityManager()->flush();
        return $idOrCustomerL;
    }
    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrCustomerL) : EntityInterface
    {
        if (!$idOrCustomerL instanceof EntityInterface) {
            $idOrCustomerL = $this->get($idOrCustomerL);
        }
        if (!$idOrCustomerL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: CustomerL');
        }
        $idOrCustomerL->setDeleteFlag(true);
        $this->getEntityManager()->merge($idOrCustomerL);
        $this->getEntityManager()->flush();
        return $idOrCustomerL;
    }
    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrCustomerL)
    {
        if (!$idOrCustomerL instanceof EntityInterface) {
            $idOrCustomerL = $this->get($idOrCustomerL);
        }
        if (!$idOrCustomerL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: CustomerL');
        }
        $this->getEntityManager()->remove($idOrCustomerL);
        $this->getEntityManager()->flush();
    }
    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(CustomerL::class);
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
            'logType' => [
                1 => 'CUSTOMERL_LOGTYPE_EDIT',
                2 => 'CUSTOMERL_LOGTYPE_PASSWORD',
                3 => 'CUSTOMERL_LOGTYPE_WITHDRAW',
                4 => 'CUSTOMERL_LOGTYPE_DELETE',
                5 => 'CUSTOMERL_LOGTYPE_BATCHUPDATE',
            ],
            'tempPasswordFlag' => [
                0 => 'CUSTOMERL_TEMPPASSWORDFLAG_OFF',
                1 => 'CUSTOMERL_TEMPPASSWORDFLAG_ON',
            ],
            'deleteFlag' => [
                0 => 'CUSTOMERL_DELETEFLAG_OFF',
                1 => 'CUSTOMERL_DELETEFLAG_ON',
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
            'customerLId' => 'CUSTOMERL_CUSTOMERLID',
            'logType' => 'CUSTOMERL_LOGTYPE',
            'login' => 'CUSTOMERL_LOGIN',
            'nameSei' => 'CUSTOMERL_NAMESEI',
            'nameMei' => 'CUSTOMERL_NAMEMEI',
            'kanaSei' => 'CUSTOMERL_KANASEI',
            'kanaMei' => 'CUSTOMERL_KANAMEI',
            'customerPassword' => 'CUSTOMERL_CUSTOMERPASSWORD',
            'customerPasswordConfirm' => 'CUSTOMERL_CUSTOMERPASSWORDCONFIRM',
            'tempPasswordFlag' => 'CUSTOMERL_TEMPPASSWORDFLAG',
            'mPrefectureId' => 'CUSTOMERL_MPREFECTUREID',
            'zipCd' => 'CUSTOMERL_ZIPCD',
            'address01' => 'CUSTOMERL_ADDRESS01',
            'address02' => 'CUSTOMERL_ADDRESS02',
            'address03' => 'CUSTOMERL_ADDRESS03',
            'email' => 'CUSTOMERL_EMAIL',
            'phone' => 'CUSTOMERL_PHONE',
            'birthDate' => 'CUSTOMERL_BIRTHDATE',
            'memberRegisterDate' => 'CUSTOMERL_MEMBERREGISTERDATE',
            'memberWithdrawDate' => 'CUSTOMERL_MEMBERWITHDRAWDATE',
            'createDate' => 'CUSTOMERL_CREATEDATE',
            'createTime' => 'CUSTOMERL_CREATETIME',
            'createAdminId' => 'CUSTOMERL_CREATEADMINID',
            'updateDate' => 'CUSTOMERL_UPDATEDATE',
            'updateTime' => 'CUSTOMERL_UPDATETIME',
            'updateAdminId' => 'CUSTOMERL_UPDATEADMINID',
            'deleteFlag' => 'CUSTOMERL_DELETEFLAG',
            'Customer' => 'CUSTOMERL_CUSTOMER',
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
        if (isset($data['customerLId'])) {
            unset($data['customerLId']);
        }
        // 空白文字列フィルター
        if (isset($data['logType']) && '' === $data['logType']) {
            unset($data['logType']);
        }
        if (isset($data['customerPassword']) && '' === $data['customerPassword']) {
            unset($data['customerPassword']);
        }
        if (isset($data['tempPasswordFlag']) && '' === $data['tempPasswordFlag']) {
            unset($data['tempPasswordFlag']);
        }
        if (isset($data['mPrefectureId']) && '' === $data['mPrefectureId']) {
            unset($data['mPrefectureId']);
        }
        if (isset($data['email']) && '' === $data['email']) {
            unset($data['email']);
        }
        if (isset($data['phone']) && '' === $data['phone']) {
            unset($data['phone']);
        }
        if (isset($data['birthDate']) && '' === $data['birthDate']) {
            unset($data['birthDate']);
        }
        if (isset($data['memberRegisterDate']) && '' === $data['memberRegisterDate']) {
            unset($data['memberRegisterDate']);
        }
        if (isset($data['memberWithdrawDate']) && '' === $data['memberWithdrawDate']) {
            unset($data['memberWithdrawDate']);
        }
        if (isset($data['Customer']) && '' === $data['Customer']) {
            unset($data['Customer']);
        }
        return $data;
    }
}
