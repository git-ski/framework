<?php
declare(strict_types=1);

namespace Project\History\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\History\Entity\AdminOperationL;
use InvalidArgumentException;

class AdminOperationLModel extends AbstractEntityModel implements
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
        $AdminOperationL = new AdminOperationL();
        $data = $this->filterValues($data);
        $AdminOperationL->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $AdminOperationL->setCreateDate($DateTime->format('Y-m-d'));
        $AdminOperationL->setCreateTime($DateTime->format('H:i:s'));
        $AdminOperationL->setCreateAdminId($this->getCreateAdminId());
        $this->getEntityManager()->persist($AdminOperationL);
        $this->getEntityManager()->flush();
        return $AdminOperationL;
    }

    /**
     * DoctrineのBulk Insertを使って、大量データのinsertを効率化する
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/batch-processing.html#batch-processing
     *
     * @param Generator $dataGenerator
     * @param integer $batchSize
     * @return AdminOperationLModel
     */
    public function bulkCreate(Generator $dataGenerator, $batchSize = 1000)
    {
        $index = 0;
        foreach ($dataGenerator as $data) {
            ++$index;
            $AdminOperationL = new AdminOperationL();
            $data = $this->filterValues($data);
            $AdminOperationL->fromArray($data);
            $DateTime = $this->getDateTimeForEntity();
            $AdminOperationL->setCreateDate($DateTime->format('Y-m-d'));
            $AdminOperationL->setCreateTime($DateTime->format('H:i:s'));
            $AdminOperationL->setCreateAdminId($this->getCreateAdminId());
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
    public function get($idOrAdminOperationL)
    {
        if ($idOrAdminOperationL instanceof AdminOperationL) {
            return $idOrAdminOperationL;
        }

        return $this->getRepository()->findOneBy([
            'adminOperationLId' => $idOrAdminOperationL,
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
                'adminOperationLId' => 'ASC',
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
                'adminOperationLId' => 'ASC',
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
    public function update($idOrAdminOperationL, $data = null) : EntityInterface
    {
        if (!$idOrAdminOperationL instanceof EntityInterface) {
            $idOrAdminOperationL = $this->get($idOrAdminOperationL);
        }
        if (!$idOrAdminOperationL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: AdminOperationL');
        }
        if ($data) {
            $data = $this->filterValues($data);
            $idOrAdminOperationL->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $this->getEntityManager()->merge($idOrAdminOperationL);
        $this->getEntityManager()->flush();
        return $idOrAdminOperationL;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrAdminOperationL) : EntityInterface
    {
        throw new InvalidArgumentException('AdminOperationL にdeleteFlagが存在しないため、論理削除できません。');
        $AdminOperationL = $this->get($idOrAdminOperationL);
        if (!$AdminOperationL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: AdminOperationL');
        }
        $AdminOperationL->setDeleteFlag(true);
        $this->getEntityManager()->merge($AdminOperationL);
        $this->getEntityManager()->flush();
        return $AdminOperationL;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrAdminOperationL)
    {
        $AdminOperationL = $this->get($idOrAdminOperationL);
        if (!$AdminOperationL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: AdminOperationL');
        }
        $this->getEntityManager()->remove($AdminOperationL);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(AdminOperationL::class);
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
            'adminOperationLId' => 'ADMINOPERATIONL_ADMINOPERATIONLID',
            'mAdminId' => 'ADMINOPERATIONL_MADMINID',
            'url' => 'ADMINOPERATIONL_URL',
            'action' => 'ADMINOPERATIONL_ACTION',
            'data' => 'ADMINOPERATIONL_DATA',
            'createDate' => 'ADMINOPERATIONL_CREATEDATE',
            'createTime' => 'ADMINOPERATIONL_CREATETIME',
            'createAdminId' => 'ADMINOPERATIONL_CREATEADMINID',
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
        if (isset($data['adminOperationLId'])) {
            unset($data['adminOperationLId']);
        }
        // 空白文字列フィルター
        if (isset($data['mAdminId']) && '' === $data['mAdminId']) {
            unset($data['mAdminId']);
        }
        if (isset($data['data']) && '' === $data['data']) {
            unset($data['data']);
        }
        return $data;
    }

}
