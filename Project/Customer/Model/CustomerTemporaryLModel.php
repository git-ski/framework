<?php
declare(strict_types=1);

namespace Project\Customer\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Customer\Entity\CustomerTemporaryL;
use InvalidArgumentException;

class CustomerTemporaryLModel extends AbstractEntityModel implements
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
        $CustomerTemporaryL = new CustomerTemporaryL();
        $data = $this->filterValues($data);
        $CustomerTemporaryL->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $CustomerTemporaryL->setCreateDate($DateTime->format('Y-m-d'));
        $CustomerTemporaryL->setCreateTime($DateTime->format('H:i:s'));
        $this->getEntityManager()->persist($CustomerTemporaryL);
        $this->getEntityManager()->flush();
        return $CustomerTemporaryL;
    }

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrCustomerTemporaryL)
    {
        if ($idOrCustomerTemporaryL instanceof CustomerTemporaryL) {
            return $idOrCustomerTemporaryL;
        }

        return $this->getRepository()->findOneBy([
            'customerTemporaryLId' => $idOrCustomerTemporaryL,
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
                'customerTemporaryLId' => 'ASC',
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
                'customerTemporaryLId' => 'ASC',
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
    public function update($idOrCustomerTemporaryL, $data = null) : EntityInterface
    {
        if (!$idOrCustomerTemporaryL instanceof EntityInterface) {
            $idOrCustomerTemporaryL = $this->get($idOrCustomerTemporaryL);
        }
        if (!$idOrCustomerTemporaryL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: CustomerTemporaryL');
        }
        if ($data) {
            $data = $this->filterValues($data);
            $idOrCustomerTemporaryL->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $this->getEntityManager()->merge($idOrCustomerTemporaryL);
        $this->getEntityManager()->flush();
        return $idOrCustomerTemporaryL;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrCustomerTemporaryL) : EntityInterface
    {
        throw new InvalidArgumentException('CustomerTemporaryL にdeleteFlagが存在しないため、論理削除できません。');
        if (!$idOrCustomerTemporaryL instanceof EntityInterface) {
            $idOrCustomerTemporaryL = $this->get($idOrCustomerTemporaryL);
        }
        if (!$idOrCustomerTemporaryL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: CustomerTemporaryL');
        }
        $idOrCustomerTemporaryL->setDeleteFlag(true);
        $this->getEntityManager()->merge($idOrCustomerTemporaryL);
        $this->getEntityManager()->flush();
        return $idOrCustomerTemporaryL;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrCustomerTemporaryL)
    {
        if (!$idOrCustomerTemporaryL instanceof EntityInterface) {
            $idOrCustomerTemporaryL = $this->get($idOrCustomerTemporaryL);
        }
        if (!$idOrCustomerTemporaryL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: CustomerTemporaryL');
        }
        $this->getEntityManager()->remove($idOrCustomerTemporaryL);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(CustomerTemporaryL::class);
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
            'type' => [
                1 => 'CUSTOMERTEMPORARYL_TYPE_CUSTOMER',
            ],
            'useFlag' => [
                0 => 'CUSTOMERTEMPORARYL_USEFLAG_OFF',
                1 => 'CUSTOMERTEMPORARYL_USEFLAG_ON',
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
            'customerTemporaryLId' => 'CUSTOMERTEMPORARYL_CUSTOMERTEMPORARYLID',
            'type' => 'CUSTOMERTEMPORARYL_TYPE',
            'urlHashKey' => 'CUSTOMERTEMPORARYL_URLHASHKEY',
            'email' => 'CUSTOMERTEMPORARYL_EMAIL',
            'redirectTo' => 'CUSTOMERTEMPORARYL_REDIRECTTO',
            'useFlag' => 'CUSTOMERTEMPORARYL_USEFLAG',
            'createDate' => 'CUSTOMERTEMPORARYL_CREATEDATE',
            'createTime' => 'CUSTOMERTEMPORARYL_CREATETIME',
            'frontCustomerTemporaryEmail' => 'FRONT_CUSTOMER_TEMPORARY_EMAIL',
            'frontCustomerTemporaryPolicy' => 'FRONT_CUSTOMER_TEMPORARY_POLICY',
            'frontEmailPlaceholder' => 'FRONT_EMAIL_PLACEHOLDER',
            'frontLoginPlaceholder' => 'FRONT_LOGIN_PLACEHOLDER',
            'frontTermsAgreements' => 'FRONT_TERMS_AGREEMENTS',
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
        if (isset($data['customerTemporaryLId'])) {
            unset($data['customerTemporaryLId']);
        }
        // 空白文字列フィルター
        if (isset($data['type']) && '' === $data['type']) {
            unset($data['type']);
        }
        if (isset($data['email']) && '' === $data['email']) {
            unset($data['email']);
        }
        if (isset($data['useFlag']) && '' === $data['useFlag']) {
            unset($data['useFlag']);
        }
        return $data;
    }

}
