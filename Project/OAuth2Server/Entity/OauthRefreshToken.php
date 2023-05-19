<?php

namespace Project\OAuth2Server\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OauthRefreshToken
 *
 * @ORM\Table(name="t_oauth_refresh_tokens", indexes={@ORM\Index(name="fk_t_oauth_access_token_id_tort", columns={"t_oauth_access_token_id"})})
 * @ORM\Entity
 */
class OauthRefreshToken extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="t_oauth_refresh_token_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="MリフレッシュトークンID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $oauthRefreshTokenId;

    /**
     * @var string
     *
     * @ORM\Column(name="refresh_token", type="string", length=256, nullable=false, options={"comment"="MロールID"})
     */
    private $refreshToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_datetime", type="string", nullable=false, options={"comment"="作成日"})
     */
    private $createDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_datetime", type="string", nullable=false, options={"comment"="更新日"})
     */
    private $updateDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiry_datetime", type="string", nullable=false, options={"comment"="失効日"})
     */
    private $expiryDatetime;

    /**
     * @var bool
     *
     * @ORM\Column(name="delete_flag", type="integer", nullable=false, options={"comment"="削除フラグ [0:未削除 1:削除済み]"})
     */
    private $deleteFlag = '0';

    /**
     * @var \Project\OAuth2Server\Entity\OauthAccessToken
     *
     * @ORM\ManyToOne(targetEntity="Project\OAuth2Server\Entity\OauthAccessToken")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="t_oauth_access_token_id", referencedColumnName="t_oauth_access_token_id")
     * })
     */
    private $OauthAccessToken;


    /**
     * Get oauthRefreshTokenId.
     *
     * @return int
     */
    public function getOauthRefreshTokenId()
    {
        return $this->oauthRefreshTokenId;
    }

    /**
     * Set refreshToken.
     *
     * @param string $refreshToken
     *
     * @return OauthRefreshToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * Get refreshToken.
     *
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * Set createDatetime.
     *
     * @param \DateTime $createDatetime
     *
     * @return OauthRefreshToken
     */
    public function setCreateDatetime($createDatetime)
    {
        $this->createDatetime = $createDatetime;

        return $this;
    }

    /**
     * Get createDatetime.
     *
     * @return \DateTime
     */
    public function getCreateDatetime()
    {
        return $this->createDatetime;
    }

    /**
     * Set updateDatetime.
     *
     * @param \DateTime $updateDatetime
     *
     * @return OauthRefreshToken
     */
    public function setUpdateDatetime($updateDatetime)
    {
        $this->updateDatetime = $updateDatetime;

        return $this;
    }

    /**
     * Get updateDatetime.
     *
     * @return \DateTime
     */
    public function getUpdateDatetime()
    {
        return $this->updateDatetime;
    }

    /**
     * Set expiryDatetime.
     *
     * @param \DateTime $expiryDatetime
     *
     * @return OauthRefreshToken
     */
    public function setExpiryDatetime($expiryDatetime)
    {
        $this->expiryDatetime = $expiryDatetime;

        return $this;
    }

    /**
     * Get expiryDatetime.
     *
     * @return \DateTime
     */
    public function getExpiryDatetime()
    {
        return $this->expiryDatetime;
    }

    /**
     * Set deleteFlag.
     *
     * @param bool $deleteFlag
     *
     * @return OauthRefreshToken
     */
    public function setDeleteFlag($deleteFlag)
    {
        $this->deleteFlag = $deleteFlag;

        return $this;
    }

    /**
     * Get deleteFlag.
     *
     * @return bool
     */
    public function getDeleteFlag()
    {
        return $this->deleteFlag;
    }

    /**
     * Set oauthAccessToken.
     *
     * @param \Project\OAuth2Server\Entity\OauthAccessToken|null $oauthAccessToken
     *
     * @return OauthRefreshToken
     */
    public function setOauthAccessToken(\Project\OAuth2Server\Entity\OauthAccessToken $oauthAccessToken = null)
    {
        $this->OauthAccessToken = $oauthAccessToken;

        return $this;
    }

    /**
     * Get oauthAccessToken.
     *
     * @return \Project\OAuth2Server\Entity\OauthAccessToken|null
     */
    public function getOauthAccessToken()
    {
        return $this->OauthAccessToken;
    }
}
