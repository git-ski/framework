<?php

namespace Project\OAuth2Server\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OauthAccessToken
 *
 * @ORM\Table(name="t_oauth_access_tokens", indexes={@ORM\Index(name="fk_m_customer_id_toat", columns={"m_customer_id"}), @ORM\Index(name="idx_access_token_toat", columns={"access_token"}), @ORM\Index(name="fk_m_admin_id_toat", columns={"m_admin_id"}), @ORM\Index(name="fk_m_oauth_client_id_toat", columns={"m_oauth_client_id"})})
 * @ORM\Entity
 */
class OauthAccessToken extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="t_oauth_access_token_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="MアクセストークンID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $oauthAccessTokenId;

    /**
     * @var string
     *
     * @ORM\Column(name="access_token", type="string", length=256, nullable=false, options={"comment"="MロールID"})
     */
    private $accessToken;

    /**
     * @var string|null
     *
     * @ORM\Column(name="scopes", type="text", length=65535, nullable=true, options={"comment"="スコープ"})
     */
    private $scopes;

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
     * @var \Project\AdminUser\Entity\Admin
     *
     * @ORM\ManyToOne(targetEntity="Project\AdminUser\Entity\Admin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="m_admin_id", referencedColumnName="m_admin_id")
     * })
     */
    private $Admin;

    /**
     * @var \Project\Customer\Entity\Customer
     *
     * @ORM\ManyToOne(targetEntity="Project\Customer\Entity\Customer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="m_customer_id", referencedColumnName="m_customer_id")
     * })
     */
    private $Customer;

    /**
     * @var \Project\OAuth2Server\Entity\OauthClient
     *
     * @ORM\ManyToOne(targetEntity="Project\OAuth2Server\Entity\OauthClient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="m_oauth_client_id", referencedColumnName="m_oauth_client_id")
     * })
     */
    private $OauthClient;


    /**
     * Get oauthAccessTokenId.
     *
     * @return int
     */
    public function getOauthAccessTokenId()
    {
        return $this->oauthAccessTokenId;
    }

    /**
     * Set accessToken.
     *
     * @param string $accessToken
     *
     * @return OauthAccessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get accessToken.
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set scopes.
     *
     * @param string|null $scopes
     *
     * @return OauthAccessToken
     */
    public function setScopes($scopes = null)
    {
        $this->scopes = $scopes;

        return $this;
    }

    /**
     * Get scopes.
     *
     * @return string|null
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * Set createDatetime.
     *
     * @param \DateTime $createDatetime
     *
     * @return OauthAccessToken
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
     * @return OauthAccessToken
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
     * @return OauthAccessToken
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
     * @return OauthAccessToken
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
     * Set admin.
     *
     * @param \Project\AdminUser\Entity\Admin|null $admin
     *
     * @return OauthAccessToken
     */
    public function setAdmin(\Project\AdminUser\Entity\Admin $admin = null)
    {
        $this->Admin = $admin;

        return $this;
    }

    /**
     * Get admin.
     *
     * @return \Project\AdminUser\Entity\Admin|null
     */
    public function getAdmin()
    {
        return $this->Admin;
    }

    /**
     * Set customer.
     *
     * @param \Project\Customer\Entity\Customer|null $customer
     *
     * @return OauthAccessToken
     */
    public function setCustomer(\Project\Customer\Entity\Customer $customer = null)
    {
        $this->Customer = $customer;

        return $this;
    }

    /**
     * Get customer.
     *
     * @return \Project\Customer\Entity\Customer|null
     */
    public function getCustomer()
    {
        return $this->Customer;
    }

    /**
     * Set oauthClient.
     *
     * @param \Project\OAuth2Server\Entity\OauthClient|null $oauthClient
     *
     * @return OauthAccessToken
     */
    public function setOauthClient(\Project\OAuth2Server\Entity\OauthClient $oauthClient = null)
    {
        $this->OauthClient = $oauthClient;

        return $this;
    }

    /**
     * Get oauthClient.
     *
     * @return \Project\OAuth2Server\Entity\OauthClient|null
     */
    public function getOauthClient()
    {
        return $this->OauthClient;
    }
}
