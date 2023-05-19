<?php
declare(strict_types=1);

namespace Project\AdminUser\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\AdminUser\Entity\AdminL;
use Project\AdminUser\Model\AdminModel;
use InvalidArgumentException;

class AdminLModel extends AbstractEntityModel implements
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
        $AdminL = new AdminL();
        $data = $this->filterValues($data);
        if (isset($data['Admin'])) {
            $AdminModel = $this->getObjectManager()->get(AdminModel::class);
            $data['Admin'] = $AdminModel->get($data['Admin']);
        }
        $AdminL->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $AdminL->setCreateDate($DateTime->format('Y-m-d'));
        $AdminL->setCreateTime($DateTime->format('H:i:s'));
        $AdminL->setCreateAdminId($this->getCreateAdminId());
        $AdminL->setUpdateDate($DateTime->format('Y-m-d'));
        $AdminL->setUpdateTime($DateTime->format('H:i:s'));
        $AdminL->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($AdminL);
        $this->getEntityManager()->flush();
        return $AdminL;
    }

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrAdminL)
    {
        if ($idOrAdminL instanceof AdminL) {
            return $idOrAdminL;
        }
        return $this->getRepository()->findOneBy([
            'adminLId' => $idOrAdminL,
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
                'adminLId' => 'ASC',
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
    public function update($idOrAdminL, $data = null) : EntityInterface
    {
        if (!$idOrAdminL instanceof EntityInterface) {
            $idOrAdminL = $this->get($idOrAdminL);
        }
        if (!$idOrAdminL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: AdminL');
        }
        if ($data) {
            $data = $this->filterValues($data);
            if (isset($data['Admin'])) {
                $AdminModel = $this->getObjectManager()->get(AdminModel::class);
                $data['Admin'] = $AdminModel->get($data['Admin']);
            }
            $idOrAdminL->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrAdminL->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrAdminL->setUpdateTime($DateTime->format('H:i:s'));
        $idOrAdminL->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrAdminL);
        $this->getEntityManager()->flush();
        return $idOrAdminL;
    }

    /**
     * Entityを削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrAdminL) : EntityInterface
    {
        if (!$idOrAdminL instanceof EntityInterface) {
            $idOrAdminL = $this->get($idOrAdminL);
        }
        if (!$idOrAdminL instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: AdminL');
        }
        $idOrAdminL->setDeleteFlag(true);
        $this->getEntityManager()->merge($idOrAdminL);
        $this->getEntityManager()->flush();
        return $idOrAdminL;
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(AdminL::class);
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
                1 => 'ADMINL_LOGTYPE_EDIT',
                2 => 'ADMINL_LOGTYPE_PASSWORD',
            ],
            'tempPasswordFlag' => [
                0 => 'ADMINL_TEMPPASSWORDFLAG_OFF',
                1 => 'ADMINL_TEMPPASSWORDFLAG_ON',
            ],
            'deleteFlag' => [
                0 => 'ADMINL_DELETEFLAG_OFF',
                1 => 'ADMINL_DELETEFLAG_ON',
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
            'adminLId' => 'ADMINL_ADMINLID',
            'logType' => 'ADMINL_LOGTYPE',
            'login' => 'ADMINL_LOGIN',
            'adminName' => 'ADMINL_ADMINNAME',
            'adminKana' => 'ADMINL_ADMINKANA',
            'adminPassword' => 'ADMINL_ADMINPASSWORD',
            'adminPasswordConfirm' => 'ADMINL_ADMINPASSWORDCONFIRM',
            'tempPasswordFlag' => 'ADMINL_TEMPPASSWORDFLAG',
            'email' => 'ADMINL_EMAIL',
            'lastLoginDate' => 'ADMINL_LASTLOGINDATE',
            'mRoleId' => 'ADMINL_MROLEID',
            'showPriority' => 'ADMINL_SHOWPRIORITY',
            'createDate' => 'ADMINL_CREATEDATE',
            'createTime' => 'ADMINL_CREATETIME',
            'createAdminId' => 'ADMINL_CREATEADMINID',
            'updateDate' => 'ADMINL_UPDATEDATE',
            'updateTime' => 'ADMINL_UPDATETIME',
            'updateAdminId' => 'ADMINL_UPDATEADMINID',
            'deleteFlag' => 'ADMINL_DELETEFLAG',
            'Admin' => 'ADMINL_ADMIN',
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
        if (isset($data['adminLId'])) {
            unset($data['adminLId']);
        }
        // 空白文字列フィルター
        if (isset($data['logType']) && '' === $data['logType']) {
            unset($data['logType']);
        }
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
        if (isset($data['mRoleId']) && '' === $data['mRoleId']) {
            unset($data['mRoleId']);
        }
        if (isset($data['showPriority']) && '' === $data['showPriority']) {
            unset($data['showPriority']);
        }
        if (isset($data['Admin']) && '' === $data['Admin']) {
            unset($data['Admin']);
        }
        return $data;
    }
}
