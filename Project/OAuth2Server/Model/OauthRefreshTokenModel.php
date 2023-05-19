<?php
declare(strict_types=1);

namespace Project\OAuth2Server\Model;

use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\EntityManager\AbstractEntityModel;
use Std\EntityManager\EntityInterface;
use Project\OAuth2Server\Entity\OauthRefreshToken;
use Project\OAuth2Server\Model\OauthAccessTokenModel;
use InvalidArgumentException;

class OauthRefreshTokenModel extends AbstractEntityModel implements
    EntityManagerAwareInterface,
    ConfigManagerAwareInterface,
    CryptManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;

    private $Repository;
    private static $OauthAccessTokenObjects;

    /**
     * Entityを作成
     *
     * @param array $data
     * @return EntityInterface
     */
    public function create($data) : EntityInterface
    {
        $OauthRefreshToken = new OauthRefreshToken();
        $data = $this->filterValues($data);
        if (isset($data['OauthAccessToken'])) {
            $OauthAccessTokenModel = $this->getObjectManager()->get(OauthAccessTokenModel::class);
            $data['OauthAccessToken'] = $OauthAccessTokenModel->get($data['OauthAccessToken']);
        }
        $OauthRefreshToken->fromArray($data);
        $DateTime = $this->getDateTimeForEntity();
        $OauthRefreshToken->setCreateDatetime($DateTime->format('Y-m-d H:i:s'));
        $OauthRefreshToken->setUpdateDatetime($DateTime->format('Y-m-d H:i:s'));
        $this->getEntityManager()->persist($OauthRefreshToken);
        $this->getEntityManager()->flush();
        return $OauthRefreshToken;
    }

    /**
     * DoctrineのBulk Insertを使って、大量データのinsertを効率化する
     * http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/batch-processing.html#batch-processing
     *
     * @param Generator $dataGenerator
     * @param integer $batchSize
     * @return OauthRefreshTokenModel
     */
    public function bulkCreate(Generator $dataGenerator, $batchSize = 1000)
    {
        $index = 0;
        foreach ($dataGenerator as $data) {
            ++$index;
            $OauthRefreshToken = new OauthRefreshToken();
            $data = $this->filterValues($data);
            if (isset($data['OauthAccessToken'])) {
                $OauthAccessTokenModel = $this->getObjectManager()->get(OauthAccessTokenModel::class);
                $data['OauthAccessToken'] = $OauthAccessTokenModel->get($data['OauthAccessToken']);
            }
            $OauthRefreshToken->fromArray($data);
            $DateTime = $this->getDateTimeForEntity();
            $OauthRefreshToken->setCreateDatetime($DateTime->format('Y-m-d H:i:s'));
            $OauthRefreshToken->setUpdateDatetime($DateTime->format('Y-m-d H:i:s'));
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
    public function get($idOrOauthRefreshToken)
    {
        if ($idOrOauthRefreshToken instanceof OauthRefreshToken) {
            return $idOrOauthRefreshToken;
        }

        return $this->getRepository()->findOneBy([
            'oauthRefreshTokenId' => $idOrOauthRefreshToken,
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
                'oauthRefreshTokenId' => 'ASC',
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
                'oauthRefreshTokenId' => 'ASC',
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
    public function update($idOrOauthRefreshToken, $data = null) : EntityInterface
    {
        if (!$idOrOauthRefreshToken instanceof EntityInterface) {
            $idOrOauthRefreshToken = $this->get($idOrOauthRefreshToken);
        }
        if (!$idOrOauthRefreshToken instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Update: OauthRefreshToken');
        }
        if ($data) {
            $data = $this->filterValues($data);
            if (isset($data['OauthAccessToken'])) {
                $OauthAccessTokenModel = $this->getObjectManager()->get(OauthAccessTokenModel::class);
                $data['OauthAccessToken'] = $OauthAccessTokenModel->get($data['OauthAccessToken']);
            }
            $idOrOauthRefreshToken->fromArray($data);
        }
        $DateTime = $this->getDateTimeForEntity();
        $idOrOauthRefreshToken->setUpdateDatetime($DateTime->format('Y-m-d H:i:s'));
        $this->getEntityManager()->merge($idOrOauthRefreshToken);
        $this->getEntityManager()->flush();
        return $idOrOauthRefreshToken;
    }

    /**
     * Entityを論理削除
     *
     * @param integer|EntityInterface $idOrEntity
     * @return EntityInterface
     * @throws InvalidArgumentException 更新対象が見つからない場合はExceptionを投げる
     */
    public function delete($idOrOauthRefreshToken) : EntityInterface
    {
        $OauthRefreshToken = $this->get($idOrOauthRefreshToken);
        if (!$OauthRefreshToken instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: OauthRefreshToken');
        }
        $OauthRefreshToken->setDeleteFlag(true);
        $this->getEntityManager()->merge($OauthRefreshToken);
        $this->getEntityManager()->flush();
        return $OauthRefreshToken;
    }

    /**
     * Entityを物理削除
     *
     * @param [type] $idO
     * @return void
     */
    public function remove($idOrOauthRefreshToken)
    {
        $OauthRefreshToken = $this->get($idOrOauthRefreshToken);
        if (!$OauthRefreshToken instanceof EntityInterface) {
            throw new InvalidArgumentException('Invalid Entity OR Id For Delete: OauthRefreshToken');
        }
        $this->getEntityManager()->remove($OauthRefreshToken);
        $this->getEntityManager()->flush();
    }

    public function getRepository()
    {
        if (null === $this->Repository) {
            $this->Repository = $this->getEntityManager()->getRepository(OauthRefreshToken::class);
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
                0 => 'OAUTHREFRESHTOKEN_DELETEFLAG_OFF',
                1 => 'OAUTHREFRESHTOKEN_DELETEFLAG_ON',
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
            'oauthRefreshTokenId' => 'OAUTHREFRESHTOKEN_OAUTHREFRESHTOKENID',
            'refreshToken' => 'OAUTHREFRESHTOKEN_REFRESHTOKEN',
            'createDatetime' => 'OAUTHREFRESHTOKEN_CREATEDATETIME',
            'updateDatetime' => 'OAUTHREFRESHTOKEN_UPDATEDATETIME',
            'expiryDatetime' => 'OAUTHREFRESHTOKEN_EXPIRYDATETIME',
            'deleteFlag' => 'OAUTHREFRESHTOKEN_DELETEFLAG',
            'OauthAccessToken' => 'OAUTHREFRESHTOKEN_OAUTHACCESSTOKEN',
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
        if (isset($data['oauthRefreshTokenId'])) {
            unset($data['oauthRefreshTokenId']);
        }
        // 空白文字列フィルター
        if (isset($data['expiryDatetime']) && '' === $data['expiryDatetime']) {
            unset($data['expiryDatetime']);
        }
        if (isset($data['OauthAccessToken']) && '' === $data['OauthAccessToken']) {
            unset($data['OauthAccessToken']);
        }
        return $data;
    }

    public static function getOauthAccessTokenObjects($label = null, array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        if (null === self::$OauthAccessTokenObjects) {
            self::$OauthAccessTokenObjects = [];
            $OauthAccessTokenModel = ObjectManager::getSingleton()->get(OauthAccessTokenModel::class);
            // 検索条件の拡張や調整はここ

            self::$OauthAccessTokenObjects = $OauthAccessTokenModel->getList($criteria, $orderBy, $limit, $offset);
        }
        if (null === $label) {
            $label = '';
        }
        $valueOptions = [];
        foreach (self::$OauthAccessTokenObjects as $OauthAccessToken) {
            $id                = $OauthAccessToken->getOauthAccessTokenId();
            $valueOptions[$id] = $OauthAccessToken->getOauthAccessTokenId();
        }
        return $valueOptions;
    }

    public static function getOauthAccessTokenObjectsHaystack()
    {
        $hayStack = [];
        if (null === self::$OauthAccessTokenObjects) {
            self::getOauthAccessTokenObjects();
        }
        foreach (self::$OauthAccessTokenObjects as $OauthAccessToken) {
            $hayStack[] = $OauthAccessToken->getOauthAccessTokenId();
        }
        return $hayStack;
    }
}
