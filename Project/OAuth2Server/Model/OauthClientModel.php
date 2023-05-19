<?php
declare(strict_types=1);

namespace Project\OAuth2Server\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\OAuth2Server\Entity\OauthClient;
use InvalidArgumentException;

class OauthClientModel extends AbstractEntityModel implements
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
        $OauthClient = new OauthClient();
        $data = $this->filterValues($data);
        $data['password'] = $this->getCryptManager()->getPasswordCrypt()->create($data['password']);
        $OauthClient->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $OauthClient->setCreateDate($DateTime->format('Y-m-d'));
        $OauthClient->setCreateTime($DateTime->format('H:i:s'));
        $OauthClient->setCreateAdminId($this->getCreateAdminId());
        $OauthClient->setUpdateDate($DateTime->format('Y-m-d'));
        $OauthClient->setUpdateTime($DateTime->format('H:i:s'));
        $OauthClient->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->persist($OauthClient);
        $this->getEntityManager()->flush();
        return $OauthClient;
    }

    /**
     * DoctrineのBulk Insertを使って、大量データのinsertを効率化する
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/batch-processing.html#batch-processing
     *
     * @param Generator $dataGenerator
     * @param integer $batchSize
     * @return OauthClientModel
     */
    public function bulkCreate(Generator $dataGenerator, $batchSize = 1000)
    {
        $index = 0;
        foreach ($dataGenerator as $data) {
            ++$index;
            $OauthClient = new OauthClient();
            $data = $this->filterValues($data);
            $data['password'] = $this->getCryptManager()->getPasswordCrypt()->create($data['password']);
            $OauthClient->fromArray($data);
            $DateTime = $this->getDateTimeForEntity();
            $OauthClient->setCreateDate($DateTime->format('Y-m-d'));
            $OauthClient->setCreateTime($DateTime->format('H:i:s'));
            $OauthClient->setCreateAdminId($this->getCreateAdminId());
            $OauthClient->setUpdateDate($DateTime->format('Y-m-d'));
            $OauthClient->setUpdateTime($DateTime->format('H:i:s'));
            $OauthClient->setUpdateAdminId($this->getUpdateAdminId());
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
    public function get($idOrOauthClient)
    {
        if ($idOrOauthClient instanceof OauthClient) {
            return $idOrOauthClient;
        }

        return $this->getRepository()->findOneBy([
            'oauthClientId' => $idOrOauthClient,
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
                'oauthClientId' => 'ASC',
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
                'oauthClientId' => 'ASC',
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
    public function update($idOrOauthClient, $data = null) : EntityInterface
    {
        if (!$idOrOauthClient instanceof EntityInterface) {
            $idOrOauthClient = $this->get($idOrOauthClient);
        }
        if (!$idOrOauthClient instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: OauthClient');
        }
        if ($data) {
            $data = $this->filterValues($data);
            if (isset($data['password'])) {
                $data['password'] = $this->getCryptManager()->getPasswordCrypt()->create($data['password']);
            }
            $idOrOauthClient->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrOauthClient->setUpdateDate($DateTime->format('Y-m-d'));
        $idOrOauthClient->setUpdateTime($DateTime->format('H:i:s'));
        $idOrOauthClient->setUpdateAdminId($this->getUpdateAdminId());
        $this->getEntityManager()->merge($idOrOauthClient);
        $this->getEntityManager()->flush();
        return $idOrOauthClient;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrOauthClient) : EntityInterface
    {
        $OauthClient = $this->get($idOrOauthClient);
        if (!$OauthClient instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: OauthClient');
        }
        $OauthClient->setDeleteFlag(true);
        $this->getEntityManager()->merge($OauthClient);
        $this->getEntityManager()->flush();
        return $OauthClient;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrOauthClient)
    {
        $OauthClient = $this->get($idOrOauthClient);
        if (!$OauthClient instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: OauthClient');
        }
        $this->getEntityManager()->remove($OauthClient);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(OauthClient::class);
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
            'deleteFlag' => [
                0 => 'OAUTHCLIENT_DELETEFLAG_OFF',
                1 => 'OAUTHCLIENT_DELETEFLAG_ON',
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
            'oauthClientId' => 'OAUTHCLIENT_OAUTHCLIENTID',
            'name' => 'OAUTHCLIENT_NAME',
            'password' => 'OAUTHCLIENT_PASSWORD',
            'passwordConfirm' => 'OAUTHCLIENT_PASSWORDCONFIRM',
            'redirectUri' => 'OAUTHCLIENT_REDIRECTURI',
            'createDate' => 'OAUTHCLIENT_CREATEDATE',
            'createTime' => 'OAUTHCLIENT_CREATETIME',
            'createAdminId' => 'OAUTHCLIENT_CREATEADMINID',
            'updateDate' => 'OAUTHCLIENT_UPDATEDATE',
            'updateTime' => 'OAUTHCLIENT_UPDATETIME',
            'updateAdminId' => 'OAUTHCLIENT_UPDATEADMINID',
            'deleteFlag' => 'OAUTHCLIENT_DELETEFLAG',
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
        if (isset($data['oauthClientId'])) {
            unset($data['oauthClientId']);
        }
        // 空白文字列フィルター
        if (isset($data['password']) && '' === $data['password']) {
            unset($data['password']);
        }
        if (isset($data['redirectUri']) && '' === $data['redirectUri']) {
            unset($data['redirectUri']);
        }
        return $data;
    }

}
