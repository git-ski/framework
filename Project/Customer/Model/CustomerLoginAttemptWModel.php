<?php
declare(strict_types=1);

namespace Project\Customer\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Customer\Entity\CustomerLoginAttemptW;
use InvalidArgumentException;

class CustomerLoginAttemptWModel extends AbstractEntityModel implements
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
        $CustomerLoginAttemptW = new CustomerLoginAttemptW();
        $data = $this->filterValues($data);
        $CustomerLoginAttemptW->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $CustomerLoginAttemptW->setCreateDatetime($DateTime->format('Y-m-d H:i:s'));
        $CustomerLoginAttemptW->setCreateAdminId($this->getCreateAdminId());
        $CustomerLoginAttemptW->setUpdateDatetime($DateTime->format('Y-m-d H:i:s'));
        $CustomerLoginAttemptW->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($CustomerLoginAttemptW);
        $this->getEntityManager()->flush();
        return $CustomerLoginAttemptW;
    }

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrCustomerLoginAttemptW)
    {
        if ($idOrCustomerLoginAttemptW instanceof CustomerLoginAttemptW) {
            return $idOrCustomerLoginAttemptW;
        }

        return $this->getRepository()->findOneBy([
            'customerLoginAttemptWId' => $idOrCustomerLoginAttemptW,
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
                'customerLoginAttemptWId' => 'ASC',
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
                'customerLoginAttemptWId' => 'ASC',
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
    public function update($idOrCustomerLoginAttemptW, $data = null) : EntityInterface
    {
        if (!$idOrCustomerLoginAttemptW instanceof EntityInterface) {
            $idOrCustomerLoginAttemptW = $this->get($idOrCustomerLoginAttemptW);
        }
        if (!$idOrCustomerLoginAttemptW instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: CustomerLoginAttemptW');
        }
        if ($data) {
            $data = $this->filterValues($data);
            $idOrCustomerLoginAttemptW->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrCustomerLoginAttemptW->setUpdateDatetime($DateTime->format('Y-m-d H:i:s'));
        $idOrCustomerLoginAttemptW->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrCustomerLoginAttemptW);
        $this->getEntityManager()->flush();
        return $idOrCustomerLoginAttemptW;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrCustomerLoginAttemptW) : EntityInterface
    {
        if (!$idOrCustomerLoginAttemptW instanceof EntityInterface) {
            $idOrCustomerLoginAttemptW = $this->get($idOrCustomerLoginAttemptW);
        }
        if (!$idOrCustomerLoginAttemptW instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: CustomerLoginAttemptW');
        }
        $idOrCustomerLoginAttemptW->setDeleteFlag(true);
        $this->getEntityManager()->merge($idOrCustomerLoginAttemptW);
        $this->getEntityManager()->flush();
        return $idOrCustomerLoginAttemptW;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrCustomerLoginAttemptW)
    {
        if (!$idOrCustomerLoginAttemptW instanceof EntityInterface) {
            $idOrCustomerLoginAttemptW = $this->get($idOrCustomerLoginAttemptW);
        }
        if (!$idOrCustomerLoginAttemptW instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: CustomerLoginAttemptW');
        }
        $this->getEntityManager()->remove($idOrCustomerLoginAttemptW);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(CustomerLoginAttemptW::class);
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
            'status' => [
                0 => 'CUSTOMERLOGINATTEMPTW_STATUS_FAILTURE',
                1 => 'CUSTOMERLOGINATTEMPTW_STATUS_SUCCESS',
                2 => 'CUSTOMERLOGINATTEMPTW_STATUS_EXPIRATED',
            ],
            'deleteFlag' => [
                0 => 'CUSTOMERLOGINATTEMPTW_DELETEFLAG_OFF',
                1 => 'CUSTOMERLOGINATTEMPTW_DELETEFLAG_ON',
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
            'customerLoginAttemptWId' => 'CUSTOMERLOGINATTEMPTW_CUSTOMERLOGINATTEMPTWID',
            'ip' => 'CUSTOMERLOGINATTEMPTW_IP',
            'login' => 'CUSTOMERLOGINATTEMPTW_LOGIN',
            'status' => 'CUSTOMERLOGINATTEMPTW_STATUS',
            'sessionId' => 'CUSTOMERLOGINATTEMPTW_SESSIONID',
            'createDatetime' => 'CUSTOMERLOGINATTEMPTW_CREATEDATETIME',
            'createAdminId' => 'CUSTOMERLOGINATTEMPTW_CREATEADMINID',
            'updateDatetime' => 'CUSTOMERLOGINATTEMPTW_UPDATEDATETIME',
            'updateAdminId' => 'CUSTOMERLOGINATTEMPTW_UPDATEADMINID',
            'deleteFlag' => 'CUSTOMERLOGINATTEMPTW_DELETEFLAG',
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
        if (isset($data['customerLoginAttemptWId'])) {
            unset($data['customerLoginAttemptWId']);
        }
        // 空白文字列フィルター
        if (isset($data['status']) && '' === $data['status']) {
            unset($data['status']);
        }
        if (isset($data['sessionId']) && '' === $data['sessionId']) {
            unset($data['sessionId']);
        }
        return $data;
    }

}
