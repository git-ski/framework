<?php
declare(strict_types=1);

namespace Project\History\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\History\Entity\CustomerOperationL;
use InvalidArgumentException;

class CustomerOperationLModel extends AbstractEntityModel implements
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
        $CustomerOperationL = new CustomerOperationL();
        $data = $this->filterValues($data);
        $CustomerOperationL->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $CustomerOperationL->setCreateDate($DateTime->format('Y-m-d'));
        $CustomerOperationL->setCreateTime($DateTime->format('H:i:s'));
        $CustomerOperationL->setCreateAdminId($this->getCreateAdminId());
        $this->getEntityManager()->persist($CustomerOperationL);
        $this->getEntityManager()->flush();
        return $CustomerOperationL;
    }

    /**
     * DoctrineのBulk Insertを使って、大量データのinsertを効率化する
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/batch-processing.html#batch-processing
     *
     * @param Generator $dataGenerator
     * @param integer $batchSize
     * @return CustomerOperationLModel
     */
    public function bulkCreate(Generator $dataGenerator, $batchSize = 1000)
    {
        $index = 0;
        foreach ($dataGenerator as $data) {
            ++$index;
            $CustomerOperationL = new CustomerOperationL();
            $data = $this->filterValues($data);
            $CustomerOperationL->fromArray($data);
            $DateTime = $this->getDateTimeForEntity();
            $CustomerOperationL->setCreateDate($DateTime->format('Y-m-d'));
            $CustomerOperationL->setCreateTime($DateTime->format('H:i:s'));
            $CustomerOperationL->setCreateAdminId($this->getCreateAdminId());
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
    public function get($idOrCustomerOperationL)
    {
        if ($idOrCustomerOperationL instanceof CustomerOperationL) {
            return $idOrCustomerOperationL;
        }

        return $this->getRepository()->findOneBy([
            'customerOperationLId' => $idOrCustomerOperationL,
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
                'customerOperationLId' => 'ASC',
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
                'customerOperationLId' => 'ASC',
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
    public function update($idOrCustomerOperationL, $data = null) : EntityInterface
    {
        if (!$idOrCustomerOperationL instanceof EntityInterface) {
            $idOrCustomerOperationL = $this->get($idOrCustomerOperationL);
        }
        if (!$idOrCustomerOperationL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: CustomerOperationL');
        }
        if ($data) {
            $data = $this->filterValues($data);
            $idOrCustomerOperationL->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $this->getEntityManager()->merge($idOrCustomerOperationL);
        $this->getEntityManager()->flush();
        return $idOrCustomerOperationL;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrCustomerOperationL) : EntityInterface
    {
        throw new InvalidArgumentException('CustomerOperationL にdeleteFlagが存在しないため、論理削除できません。');
        $CustomerOperationL = $this->get($idOrCustomerOperationL);
        if (!$CustomerOperationL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: CustomerOperationL');
        }
        $CustomerOperationL->setDeleteFlag(true);
        $this->getEntityManager()->merge($CustomerOperationL);
        $this->getEntityManager()->flush();
        return $CustomerOperationL;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrCustomerOperationL)
    {
        $CustomerOperationL = $this->get($idOrCustomerOperationL);
        if (!$CustomerOperationL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: CustomerOperationL');
        }
        $this->getEntityManager()->remove($CustomerOperationL);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(CustomerOperationL::class);
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
            'customerOperationLId' => 'CUSTOMEROPERATIONL_CUSTOMEROPERATIONLID',
            'mCustomerId' => 'CUSTOMEROPERATIONL_MCUSTOMERID',
            'url' => 'CUSTOMEROPERATIONL_URL',
            'action' => 'CUSTOMEROPERATIONL_ACTION',
            'data' => 'CUSTOMEROPERATIONL_DATA',
            'createDate' => 'CUSTOMEROPERATIONL_CREATEDATE',
            'createTime' => 'CUSTOMEROPERATIONL_CREATETIME',
            'createAdminId' => 'CUSTOMEROPERATIONL_CREATEADMINID',
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
        if (isset($data['customerOperationLId'])) {
            unset($data['customerOperationLId']);
        }
        // 空白文字列フィルター
        if (isset($data['mCustomerId']) && '' === $data['mCustomerId']) {
            unset($data['mCustomerId']);
        }
        if (isset($data['data']) && '' === $data['data']) {
            unset($data['data']);
        }
        return $data;
    }

}
