<?php
declare(strict_types=1);

namespace Project\Permission\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Permission\Entity\AdminAcl;
use Project\AdminUser\Model\AdminModel;
use InvalidArgumentException;

class AdminAclModel extends AbstractEntityModel implements
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
        $AdminAcl = new AdminAcl();
        $data = $this->filterValues($data);
        if (isset($data['Admin'])) {
            $AdminModel = $this->getObjectManager()->get(AdminModel::class);
            $data['Admin'] = $AdminModel->get($data['Admin']);
        }
        $AdminAcl->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $this->getEntityManager()->persist($AdminAcl);
        $this->getEntityManager()->flush();
        return $AdminAcl;
    }

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrAdminAcl)
    {
        if ($idOrAdminAcl instanceof AdminAcl) {
            return $idOrAdminAcl;
        }

        return $this->getRepository()->findOneBy([
            'adminAclId' => $idOrAdminAcl,
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
                'adminAclId' => 'ASC',
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
                'adminAclId' => 'ASC',
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
    public function update($idOrAdminAcl, $data = null) : EntityInterface
    {
        if (!$idOrAdminAcl instanceof EntityInterface) {
            $idOrAdminAcl = $this->get($idOrAdminAcl);
        }
        if (!$idOrAdminAcl instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: AdminAcl');
        }
        if ($data) {
            $data = $this->filterValues($data);
            if (isset($data['Admin'])) {
                $AdminModel = $this->getObjectManager()->get(AdminModel::class);
                $data['Admin'] = $AdminModel->get($data['Admin']);
            }
            $idOrAdminAcl->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $this->getEntityManager()->merge($idOrAdminAcl);
        $this->getEntityManager()->flush();
        return $idOrAdminAcl;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrAdminAcl) : EntityInterface
    {
        throw new InvalidArgumentException('AdminAcl にdeleteFlagが存在しないため、論理削除できません。');
        $AdminAcl = $this->get($idOrAdminAcl);
        if (!$AdminAcl instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: AdminAcl');
        }
        $AdminAcl->setDeleteFlag(true);
        $this->getEntityManager()->merge($AdminAcl);
        $this->getEntityManager()->flush();
        return $AdminAcl;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrAdminAcl)
    {
        $AdminAcl = $this->get($idOrAdminAcl);
        if (!$AdminAcl instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: AdminAcl');
        }
        $this->getEntityManager()->remove($AdminAcl);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(AdminAcl::class);
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
            'adminAclId' => 'ADMINACL_ADMINACLID',
            'acl' => 'ADMINACL_ACL',
            'Admin' => 'ADMINACL_ADMIN',
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
        if (isset($data['adminAclId'])) {
            unset($data['adminAclId']);
        }
        // 空白文字列フィルター
        if (isset($data['acl']) && '' === $data['acl']) {
            unset($data['acl']);
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
