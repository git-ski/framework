<?php
declare(strict_types=1);

namespace Project\AdminUser\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\AdminUser\Entity\LoginAttemptW;
use InvalidArgumentException;

class LoginAttemptWModel extends AbstractEntityModel implements
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
        $LoginAttemptW = new LoginAttemptW();
        $data = $this->filterValues($data);
        $LoginAttemptW->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $LoginAttemptW->setCreateDatetime($DateTime->format('Y-m-d H:i:s'));
        $LoginAttemptW->setCreateAdminId($this->getCreateAdminId());
        $LoginAttemptW->setUpdateDatetime($DateTime->format('Y-m-d H:i:s'));
        $LoginAttemptW->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($LoginAttemptW);
        $this->getEntityManager()->flush();
        return $LoginAttemptW;
    }

    /**
     * Entityを取得
     *
     * @param int $id
     * @return EntityInterface|null
     */
    public function get($idOrLoginAttemptW)
    {
        if ($idOrLoginAttemptW instanceof LoginAttemptW) {
            return $idOrLoginAttemptW;
        }
        return $this->getRepository()->findOneBy([
            'loginAttemptWId' => $idOrLoginAttemptW,
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
                'loginAttemptWId' => 'ASC',
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
    public function update($idOrLoginAttemptW, $data = null) : EntityInterface
    {
        if (!$idOrLoginAttemptW instanceof EntityInterface) {
            $idOrLoginAttemptW = $this->get($idOrLoginAttemptW);
        }
        if (!$idOrLoginAttemptW instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: LoginAttemptW');
        }
        if ($data) {
            $data = $this->filterValues($data);
            $idOrLoginAttemptW->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrLoginAttemptW->setUpdateDatetime($DateTime->format('Y-m-d H:i:s'));
        $idOrLoginAttemptW->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrLoginAttemptW);
        $this->getEntityManager()->flush();
        return $idOrLoginAttemptW;
    }

    /**
     * Entityを削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrLoginAttemptW) : EntityInterface
    {
        if (!$idOrLoginAttemptW instanceof EntityInterface) {
            $idOrLoginAttemptW = $this->get($idOrLoginAttemptW);
        }
        if (!$idOrLoginAttemptW instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: LoginAttemptW');
        }
        $idOrLoginAttemptW->setDeleteFlag(true);
        $this->getEntityManager()->merge($idOrLoginAttemptW);
        $this->getEntityManager()->flush();
        return $idOrLoginAttemptW;
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(LoginAttemptW::class);
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
                0 => 'LOGINATTEMPTW_STATUS_FAILTURE',
                1 => 'LOGINATTEMPTW_STATUS_SUCCESS',
            ],
            'deleteFlag' => [
                0 => 'LOGINATTEMPTW_DELETEFLAG_OFF',
                1 => 'LOGINATTEMPTW_DELETEFLAG_ON',
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
            'loginAttemptWId' => 'LOGINATTEMPTW_LOGINATTEMPTWID',
            'ip' => 'LOGINATTEMPTW_IP',
            'login' => 'LOGINATTEMPTW_LOGIN',
            'status' => 'LOGINATTEMPTW_STATUS',
            'sessionId' => 'LOGINATTEMPTW_SESSIONID',
            'createDatetime' => 'LOGINATTEMPTW_CREATEDATETIME',
            'createAdminId' => 'LOGINATTEMPTW_CREATEADMINID',
            'updateDatetime' => 'LOGINATTEMPTW_UPDATEDATETIME',
            'updateAdminId' => 'LOGINATTEMPTW_UPDATEADMINID',
            'deleteFlag' => 'LOGINATTEMPTW_DELETEFLAG',
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
        if (isset($data['loginAttemptWId'])) {
            unset($data['loginAttemptWId']);
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
