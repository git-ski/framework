<?php
declare(strict_types=1);

namespace Project\AdminUser\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\AdminUser\Entity\Admin;
use InvalidArgumentException;
use Project\AdminUser\Admin\Authentication\AuthenticationAwareInterface;

class AdminModel extends AbstractEntityModel implements
    EntityManagerAwareInterface,
    ConfigManagerAwareInterface,
    AuthenticationAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Std\Authentication\AuthenticationAwareTrait;

    private $Repository;

    /**
     * Entityを作成
     *
     * @param array $data
     * @return EntityInterface
     */
    public function create($data) : EntityInterface
    {
        $Admin = new Admin();
        $data = $this->filterValues($data);
        $data['adminPassword'] = $this->getAuthentication()->getAdapter()->getCrypt()->create($data['adminPassword']);
        $Admin->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $Admin->setCreateDate($DateTime->format('Y-m-d'));
        $Admin->setCreateTime($DateTime->format('H:i:s'));
        $Admin->setCreateAdminId($this->getCreateAdminId());
        $Admin->setUpdateDate($DateTime->format('Y-m-d'));
        $Admin->setUpdateTime($DateTime->format('H:i:s'));
        $Admin->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($Admin);
        $this->getEntityManager()->flush();
        return $Admin;
    }

    /**
     * DoctrineのBulk Insertを使って、大量データのinsertを効率化する
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/batch-processing.html#batch-processing
     *
     * @param Generator $dataGenerator
     * @param integer $batchSize
     * @return AdminModel
     */
    public function bulkCreate(Generator $dataGenerator, $batchSize = 1000)
    {
        $index = 0;
        foreach ($dataGenerator as $data) {
            ++$index;
            $Admin = new Admin();
            $data = $this->filterValues($data);
            $data['adminPassword'] = $this->getAuthentication()->getAdapter()->getCrypt()->create($data['adminPassword']);
            $Admin->fromArray($data);
            $DateTime = $this->getDateTimeForEntity();
            $Admin->setCreateDate($DateTime->format('Y-m-d'));
            $Admin->setCreateTime($DateTime->format('H:i:s'));
            $Admin->setCreateAdminId($this->getCreateAdminId());
            $Admin->setUpdateDate($DateTime->format('Y-m-d'));
            $Admin->setUpdateTime($DateTime->format('H:i:s'));
            $Admin->setUpdateAdminId($this->getUpdateAdminId());
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
    public function get($idOrAdmin)
    {
        if ($idOrAdmin instanceof Admin) {
            return $idOrAdmin;
        }

        return $this->getRepository()->findOneBy([
            'adminId' => $idOrAdmin,
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
                'showPriority' => 'DESC',
                'adminId' => 'ASC',
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
                'showPriority' => 'DESC',
                'adminId' => 'ASC',
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
    public function update($idOrAdmin, $data = null) : EntityInterface
    {
        if (!$idOrAdmin instanceof EntityInterface) {
            $idOrAdmin = $this->get($idOrAdmin);
        }
        if (!$idOrAdmin instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: Admin');
        }
        if ($data) {
            $data = $this->filterValues($data);
            if (isset($data['adminPassword'])) {
                $data['adminPassword'] = $this->getAuthentication()->getAdapter()->getCrypt()->create($data['adminPassword']);
            }
            $idOrAdmin->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrAdmin->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrAdmin->setUpdateTime($DateTime->format('H:i:s'));
        $idOrAdmin->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrAdmin);
        $this->getEntityManager()->flush();
        return $idOrAdmin;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrAdmin) : EntityInterface
    {
        $Admin = $this->get($idOrAdmin);
        if (!$Admin instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: Admin');
        }
        $Admin->setDeleteFlag(true);
        $this->getEntityManager()->merge($Admin);
        $this->getEntityManager()->flush();
        return $Admin;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrAdmin)
    {
        $Admin = $this->get($idOrAdmin);
        if (!$Admin instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: Admin');
        }
        $this->getEntityManager()->remove($Admin);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(Admin::class);
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
                0 => 'ADMIN_TEMPPASSWORDFLAG_OFF',
                1 => 'ADMIN_TEMPPASSWORDFLAG_ON',
            ],
            'deleteFlag' => [
                0 => 'ADMIN_DELETEFLAG_OFF',
                1 => 'ADMIN_DELETEFLAG_ON',
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
            'adminId'               => 'ADMIN_ADMINID',
            'login'                 => 'ADMIN_LOGIN',
            'adminName'             => 'ADMIN_ADMINNAME',
            'adminKana'             => 'ADMIN_ADMINKANA',
            'avatar'                => 'ADMIN_AVATAR',
            'oldPassword'           => 'ADMIN_OLDPASSWORD',
            'adminPassword'         => 'ADMIN_ADMINPASSWORD',
            'adminPasswordConfirm'  => 'ADMIN_ADMINPASSWORDCONFIRM',
            'tempPasswordFlag'      => 'ADMIN_TEMPPASSWORDFLAG',
            'email'                 => 'ADMIN_EMAIL',
            'lastLoginDate'         => 'ADMIN_LASTLOGINDATE',
            'showPriority'          => 'ADMIN_SHOWPRIORITY',
            'createDate'            => 'ADMIN_CREATEDATE',
            'createTime'            => 'ADMIN_CREATETIME',
            'createAdminId'         => 'ADMIN_CREATEADMINID',
            'updateDate'            => 'ADMIN_UPDATEDATE',
            'updateTime'            => 'ADMIN_UPDATETIME',
            'updateAdminId'         => 'ADMIN_UPDATEADMINID',
            'deleteFlag'            => 'ADMIN_DELETEFLAG',
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
        if (isset($data['adminId'])) {
            unset($data['adminId']);
        }
        // 空白文字列フィルター
        if (isset($data['adminPassword']) && '' === $data['adminPassword']) {
            unset($data['adminPassword']);
        }
        if (isset($data['tempPasswordFlag']) && '' === $data['tempPasswordFlag']) {
            unset($data['tempPasswordFlag']);
        }
        if (isset($data['email']) && '' === $data['email']) {
            unset($data['email']);
        }
        if (isset($data['lastLoginDate']) && '' === $data['lastLoginDate']) {
            unset($data['lastLoginDate']);
        }
        if (isset($data['showPriority']) && '' === $data['showPriority']) {
            unset($data['showPriority']);
        }
        return $data;
    }

}
