<?php
declare(strict_types=1);

namespace Project\Permission\Model;

use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\TranslatorManager\TranslatorManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\Permission\Entity\Role;
use InvalidArgumentException;

class RoleModel extends AbstractEntityModel implements
    EntityManagerAwareInterface,
    ConfigManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;

    private $Repository;
    private $Translator;

    /**
     * Entityを作成
     *
     * @param array $data
     * @return EntityInterface
     */
    public function create($data) : EntityInterface
    {
        $Role = new Role();
        $data = $this->filterValues($data);
        $Role->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $Role->setCreateDate($DateTime->format('Y-m-d'));
        $Role->setCreateTime($DateTime->format('H:i:s'));
        $Role->setCreateAdminId($this->getCreateAdminId());
        $Role->setUpdateDate($DateTime->format('Y-m-d'));
        $Role->setUpdateTime($DateTime->format('H:i:s'));
        $Role->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($Role);
        $this->getEntityManager()->flush();
        return $Role;
    }

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrRole)
    {
        if ($idOrRole instanceof Role) {
            return $idOrRole;
        }
        return $this->getRepository()->findOneBy([
            'roleId' => $idOrRole,
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
                'roleId' => 'ASC',
                'showPriority' => 'ASC',
            ];
        }
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Entityを更新する
     *
     * @param integer|EntityInterface $idOrEntity
     * @param array                   $data
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function update($idOrRole, $data = null) : EntityInterface
    {
        if (!$idOrRole instanceof EntityInterface) {
            $idOrRole = $this->get($idOrRole);
        }
        if (!$idOrRole instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: Role');
        }
        if ($data) {
            $data = $this->filterValues($data);
            $idOrRole->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrRole->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrRole->setUpdateTime($DateTime->format('H:i:s'));
        $idOrRole->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrRole);
        $this->getEntityManager()->flush();
        return $idOrRole;
    }

    /**
     * Entityを削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrRole) : EntityInterface
    {
        if (!$idOrRole instanceof EntityInterface) {
            $idOrRole = $this->get($idOrRole);
        }
        if (!$idOrRole instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: Role');
        }
        $idOrRole->setDeleteFlag(true);
        $this->getEntityManager()->merge($idOrRole);
        $this->getEntityManager()->flush();
        return $idOrRole;
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(Role::class);
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
            'roleId' => 'ROLE_ROLEID',
            'role' => 'ROLE_ROLE',
            'showPriority' => 'ROLE_SHOWPRIORITY',
        ];
        $propertyLabel = $propertyLabels[$property] ?? null;
        return parent::getPropertyLabel((string) $propertyLabel);
    }

    /**
     * 文字列でないカラムの保存時に、空白の文字列をセットするとエラーになる
     * そのため、保存前に、空白の文字列をフィルターする
     * 特定のカラムの空値を特別扱うためには、カラムごとの処理を持つ。
     *
     * @param array $data
     * @return array
     */
    public function filterValues($data) : array
    {
        if (empty($data['roleId'])) {
            unset($data['roleId']);
        }
        if (empty($data['showPriority'])) {
            unset($data['showPriority']);
        }
        return $data;
    }
}
