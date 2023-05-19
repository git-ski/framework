<?php
declare(strict_types=1);

namespace Project\OAuth2Server\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\OAuth2Server\Entity\OauthAccessToken;
use Project\AdminUser\Model\AdminModel;
use Project\Customer\Model\CustomerModel;
use Project\OAuth2Server\Model\OauthClientModel;
use InvalidArgumentException;

class OauthAccessTokenModel extends AbstractEntityModel implements
    EntityManagerAwareInterface,
    ConfigManagerAwareInterface,
    CryptManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;

    private $Repository;
    private static $AdminObjects;
    private static $CustomerObjects;
    private static $OauthClientObjects;

    /**
     * Entityを作成
     *
     * @param array $data
     * @return EntityInterface
     */
    public function create($data) : EntityInterface
    {
        $OauthAccessToken = new OauthAccessToken();
        $data = $this->filterValues($data);
        if (isset($data['Admin'])) {
            $AdminModel = $this->getObjectManager()->get(AdminModel::class);
            $data['Admin'] = $AdminModel->get($data['Admin']);
        }
        if (isset($data['Customer'])) {
            $CustomerModel = $this->getObjectManager()->get(CustomerModel::class);
            $data['Customer'] = $CustomerModel->get($data['Customer']);
        }
        if (isset($data['OauthClient'])) {
            $OauthClientModel = $this->getObjectManager()->get(OauthClientModel::class);
            $data['OauthClient'] = $OauthClientModel->get($data['OauthClient']);
        }
        $OauthAccessToken->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $OauthAccessToken->setCreateDatetime($DateTime->format('Y-m-d H:i:s'));
        $OauthAccessToken->setUpdateDatetime($DateTime->format('Y-m-d H:i:s'));
        $this->getEntityManager()->persist($OauthAccessToken);
        $this->getEntityManager()->flush();
        return $OauthAccessToken;
    }

    /**
     * DoctrineのBulk Insertを使って、大量データのinsertを効率化する
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/batch-processing.html#batch-processing
     *
     * @param Generator $dataGenerator
     * @param integer $batchSize
     * @return OauthAccessTokenModel
     */
    public function bulkCreate(Generator $dataGenerator, $batchSize = 1000)
    {
        $index = 0;
        foreach ($dataGenerator as $data) {
            ++$index;
            $OauthAccessToken = new OauthAccessToken();
            $data = $this->filterValues($data);
            if (isset($data['Admin'])) {
                $AdminModel = $this->getObjectManager()->get(AdminModel::class);
                $data['Admin'] = $AdminModel->get($data['Admin']);
            }
            if (isset($data['Customer'])) {
                $CustomerModel = $this->getObjectManager()->get(CustomerModel::class);
                $data['Customer'] = $CustomerModel->get($data['Customer']);
            }
            if (isset($data['OauthClient'])) {
                $OauthClientModel = $this->getObjectManager()->get(OauthClientModel::class);
                $data['OauthClient'] = $OauthClientModel->get($data['OauthClient']);
            }
            $OauthAccessToken->fromArray($data);
            $DateTime = $this->getDateTimeForEntity();
            $OauthAccessToken->setCreateDatetime($DateTime->format('Y-m-d H:i:s'));
            $OauthAccessToken->setUpdateDatetime($DateTime->format('Y-m-d H:i:s'));
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
    public function get($idOrOauthAccessToken)
    {
        if ($idOrOauthAccessToken instanceof OauthAccessToken) {
            return $idOrOauthAccessToken;
        }

        return $this->getRepository()->findOneBy([
            'oauthAccessTokenId' => $idOrOauthAccessToken,
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
                'oauthAccessTokenId' => 'ASC',
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
                'oauthAccessTokenId' => 'ASC',
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
    public function update($idOrOauthAccessToken, $data = null) : EntityInterface
    {
        if (!$idOrOauthAccessToken instanceof EntityInterface) {
            $idOrOauthAccessToken = $this->get($idOrOauthAccessToken);
        }
        if (!$idOrOauthAccessToken instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: OauthAccessToken');
        }
        if ($data) {
            $data = $this->filterValues($data);
            if (isset($data['Admin'])) {
                $AdminModel = $this->getObjectManager()->get(AdminModel::class);
                $data['Admin'] = $AdminModel->get($data['Admin']);
            }
            if (isset($data['Customer'])) {
                $CustomerModel = $this->getObjectManager()->get(CustomerModel::class);
                $data['Customer'] = $CustomerModel->get($data['Customer']);
            }
            if (isset($data['OauthClient'])) {
                $OauthClientModel = $this->getObjectManager()->get(OauthClientModel::class);
                $data['OauthClient'] = $OauthClientModel->get($data['OauthClient']);
            }
            $idOrOauthAccessToken->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrOauthAccessToken->setUpdateDatetime($DateTime->format('Y-m-d H:i:s'));
        $this->getEntityManager()->merge($idOrOauthAccessToken);
        $this->getEntityManager()->flush();
        return $idOrOauthAccessToken;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrOauthAccessToken) : EntityInterface
    {
        $OauthAccessToken = $this->get($idOrOauthAccessToken);
        if (!$OauthAccessToken instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: OauthAccessToken');
        }
        $OauthAccessToken->setDeleteFlag(true);
        $this->getEntityManager()->merge($OauthAccessToken);
        $this->getEntityManager()->flush();
        return $OauthAccessToken;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrOauthAccessToken)
    {
        $OauthAccessToken = $this->get($idOrOauthAccessToken);
        if (!$OauthAccessToken instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: OauthAccessToken');
        }
        $this->getEntityManager()->remove($OauthAccessToken);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(OauthAccessToken::class);
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
                0 => 'OAUTHACCESSTOKEN_DELETEFLAG_OFF',
                1 => 'OAUTHACCESSTOKEN_DELETEFLAG_ON',
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
            'oauthAccessTokenId' => 'OAUTHACCESSTOKEN_OAUTHACCESSTOKENID',
            'accessToken' => 'OAUTHACCESSTOKEN_ACCESSTOKEN',
            'scopes' => 'OAUTHACCESSTOKEN_SCOPES',
            'createDatetime' => 'OAUTHACCESSTOKEN_CREATEDATETIME',
            'updateDatetime' => 'OAUTHACCESSTOKEN_UPDATEDATETIME',
            'expiryDatetime' => 'OAUTHACCESSTOKEN_EXPIRYDATETIME',
            'deleteFlag' => 'OAUTHACCESSTOKEN_DELETEFLAG',
            'Admin' => 'OAUTHACCESSTOKEN_ADMIN',
            'Customer' => 'OAUTHACCESSTOKEN_CUSTOMER',
            'OauthClient' => 'OAUTHACCESSTOKEN_OAUTHCLIENT',
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
        if (isset($data['oauthAccessTokenId'])) {
            unset($data['oauthAccessTokenId']);
        }
        // 空白文字列フィルター
        if (isset($data['scopes']) && '' === $data['scopes']) {
            unset($data['scopes']);
        }
        if (isset($data['expiryDatetime']) && '' === $data['expiryDatetime']) {
            unset($data['expiryDatetime']);
        }
        if (isset($data['Admin']) && '' === $data['Admin']) {
            unset($data['Admin']);
        }
        if (isset($data['Customer']) && '' === $data['Customer']) {
            unset($data['Customer']);
        }
        if (isset($data['OauthClient']) && '' === $data['OauthClient']) {
            unset($data['OauthClient']);
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
    public static function getCustomerObjects($label = null, array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        if (null === self::$CustomerObjects) {
            self::$CustomerObjects = [];
            $CustomerModel = ObjectManager::getSingleton()->get(CustomerModel::class);
            // 検索条件の拡張や調整はここ

            self::$CustomerObjects = $CustomerModel->getList($criteria, $orderBy, $limit, $offset);
        }
        if (null === $label) {
            $label = '';
        }
        $valueOptions = [];
        foreach (self::$CustomerObjects as $Customer) {
            $id                = $Customer->getCustomerId();
            $valueOptions[$id] = $Customer->getCustomerId();
        }
        return $valueOptions;
    }

    public static function getCustomerObjectsHaystack()
    {
        $hayStack = [];
        if (null === self::$CustomerObjects) {
            self::getCustomerObjects();
        }
        foreach (self::$CustomerObjects as $Customer) {
            $hayStack[] = $Customer->getCustomerId();
        }
        return $hayStack;
    }
    public static function getOauthClientObjects($label = null, array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        if (null === self::$OauthClientObjects) {
            self::$OauthClientObjects = [];
            $OauthClientModel = ObjectManager::getSingleton()->get(OauthClientModel::class);
            // 検索条件の拡張や調整はここ

            self::$OauthClientObjects = $OauthClientModel->getList($criteria, $orderBy, $limit, $offset);
        }
        if (null === $label) {
            $label = '';
        }
        $valueOptions = [];
        foreach (self::$OauthClientObjects as $OauthClient) {
            $id                = $OauthClient->getOauthClientId();
            $valueOptions[$id] = $OauthClient->getOauthClientId();
        }
        return $valueOptions;
    }

    public static function getOauthClientObjectsHaystack()
    {
        $hayStack = [];
        if (null === self::$OauthClientObjects) {
            self::getOauthClientObjects();
        }
        foreach (self::$OauthClientObjects as $OauthClient) {
            $hayStack[] = $OauthClient->getOauthClientId();
        }
        return $hayStack;
    }
}
