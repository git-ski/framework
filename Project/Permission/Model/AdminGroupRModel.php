<?php
declare(strict_types=1);

namespace Project\Permission\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Permission\Entity\AdminGroupR;
use Project\AdminUser\Model\AdminModel;
use InvalidArgumentException;

class AdminGroupRModel extends AbstractEntityModel implements
    EntityManagerAwareInterface,
    ConfigManagerAwareInterface,
    CryptManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;

    private $Repository;
    private static $AdminObjects;

    /**
     * Entityを作成
     *
     * @param array $data
     * @return EntityInterface
     */
    public function create($data) : EntityInterface
    {
        $AdminGroupR = new AdminGroupR();
        $data = $this->filterValues($data);
        if (isset($data['Admin'])) {
            $AdminModel = $this->getObjectManager()->get(AdminModel::class);
            $data['Admin'] = $AdminModel->get($data['Admin']);
        }
        $AdminGroupR->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $this->getEntityManager()->persist($AdminGroupR);
        $this->getEntityManager()->flush();
        return $AdminGroupR;
    }

    /**
     * DoctrineのBulk Insertを使って、大量データのinsertを効率化する
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/batch-processing.html#batch-processing
     *
     * @param Generator $dataGenerator
     * @param integer $batchSize
     * @return AdminGroupRModel
     */
    public function bulkCreate(Generator $dataGenerator, $batchSize = 1000)
    {
        $index = 0;
        foreach ($dataGenerator as $data) {
            ++$index;
            $AdminGroupR = new AdminGroupR();
            $data = $this->filterValues($data);
            if (isset($data['Admin'])) {
                $AdminModel = $this->getObjectManager()->get(AdminModel::class);
                $data['Admin'] = $AdminModel->get($data['Admin']);
            }
            $AdminGroupR->fromArray($data);
            $DateTime = $this->getDateTimeForEntity();
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
    public function get($idOrAdminGroupR)
    {
        if ($idOrAdminGroupR instanceof AdminGroupR) {
            return $idOrAdminGroupR;
        }

        return $this->getRepository()->findOneBy([
            'adminGroupRId' => $idOrAdminGroupR,
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
                'adminGroupRId' => 'ASC',
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
                'adminGroupRId' => 'ASC',
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
    public function update($idOrAdminGroupR, $data = null) : EntityInterface
    {
        if (!$idOrAdminGroupR instanceof EntityInterface) {
            $idOrAdminGroupR = $this->get($idOrAdminGroupR);
        }
        if (!$idOrAdminGroupR instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: AdminGroupR');
        }
        if ($data) {
            $data = $this->filterValues($data);
            if (isset($data['Admin'])) {
                $AdminModel = $this->getObjectManager()->get(AdminModel::class);
                $data['Admin'] = $AdminModel->get($data['Admin']);
            }
            $idOrAdminGroupR->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $this->getEntityManager()->merge($idOrAdminGroupR);
        $this->getEntityManager()->flush();
        return $idOrAdminGroupR;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrAdminGroupR) : EntityInterface
    {
        throw new InvalidArgumentException('AdminGroupR にdeleteFlagが存在しないため、論理削除できません。');
        $AdminGroupR = $this->get($idOrAdminGroupR);
        if (!$AdminGroupR instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: AdminGroupR');
        }
        $AdminGroupR->setDeleteFlag(true);
        $this->getEntityManager()->merge($AdminGroupR);
        $this->getEntityManager()->flush();
        return $AdminGroupR;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrAdminGroupR)
    {
        $AdminGroupR = $this->get($idOrAdminGroupR);
        if (!$AdminGroupR instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: AdminGroupR');
        }
        $this->getEntityManager()->remove($AdminGroupR);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(AdminGroupR::class);
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
            'adminGroupRId' => 'ADMINGROUPR_ADMINGROUPRID',
            'groupId' => 'ADMINGROUPR_GROUPID',
            'Admin' => 'ADMINGROUPR_ADMIN',
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
        if (isset($data['adminGroupRId'])) {
            unset($data['adminGroupRId']);
        }
        // 空白文字列フィルター
        if (isset($data['groupId']) && '' === $data['groupId']) {
            unset($data['groupId']);
        }
        if (isset($data['Admin']) && '' === $data['Admin']) {
            unset($data['Admin']);
        }
        return $data;
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
            $valueOptions[$id] = $Admin->getAdminId();
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
}
