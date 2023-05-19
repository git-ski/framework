<?php

namespace Project\OAuth2Server\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OauthClient
 *
 * @ORM\Table(name="m_oauth_clients", indexes={@ORM\Index(name="idx_name_moc", columns={"name"})})
 * @ORM\Entity
 */
class OauthClient extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="m_oauth_client_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="マスタOAuthクライアントID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $oauthClientId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false, options={"comment"="clientId"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=256, nullable=false, options={"comment"="clientSecret"})
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="redirect_uri", type="text", length=65535, nullable=false, options={"comment"="redirectUri"})
     */
    private $redirectUri;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="string", nullable=false, options={"comment"="作成日"})
     */
    private $createDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_time", type="string", nullable=false, options={"comment"="作成時"})
     */
    private $createTime;

    /**
     * @var int|null
     *
     * @ORM\Column(name="create_admin_id", type="integer", nullable=true, options={"unsigned"=true,"comment"="作成管理ユーザーID"})
     */
    private $createAdminId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="string", nullable=false, options={"comment"="更新日"})
     */
    private $updateDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="string", nullable=false, options={"comment"="更新時"})
     */
    private $updateTime;

    /**
     * @var int|null
     *
     * @ORM\Column(name="update_admin_id", type="integer", nullable=true, options={"unsigned"=true,"comment"="更新管理ユーザーID"})
     */
    private $updateAdminId;

    /**
     * @var bool
     *
     * @ORM\Column(name="delete_flag", type="integer", nullable=false, options={"comment"="削除フラグ [0:未削除 1:削除済み]"})
     */
    private $deleteFlag = '0';


    /**
     * Get oauthClientId.
     *
     * @return int
     */
    public function getOauthClientId()
    {
        return $this->oauthClientId;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return OauthClient
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return OauthClient
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set redirectUri.
     *
     * @param string $redirectUri
     *
     * @return OauthClient
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;

        return $this;
    }

    /**
     * Get redirectUri.
     *
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Set createDate.
     *
     * @param \DateTime $createDate
     *
     * @return OauthClient
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate.
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set createTime.
     *
     * @param \DateTime $createTime
     *
     * @return OauthClient
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime.
     *
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set createAdminId.
     *
     * @param int|null $createAdminId
     *
     * @return OauthClient
     */
    public function setCreateAdminId($createAdminId = null)
    {
        $this->createAdminId = $createAdminId;

        return $this;
    }

    /**
     * Get createAdminId.
     *
     * @return int|null
     */
    public function getCreateAdminId()
    {
        return $this->createAdminId;
    }

    /**
     * Set updateDate.
     *
     * @param \DateTime $updateDate
     *
     * @return OauthClient
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate.
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set updateTime.
     *
     * @param \DateTime $updateTime
     *
     * @return OauthClient
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime.
     *
     * @return \DateTime
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set updateAdminId.
     *
     * @param int|null $updateAdminId
     *
     * @return OauthClient
     */
    public function setUpdateAdminId($updateAdminId = null)
    {
        $this->updateAdminId = $updateAdminId;

        return $this;
    }

    /**
     * Get updateAdminId.
     *
     * @return int|null
     */
    public function getUpdateAdminId()
    {
        return $this->updateAdminId;
    }

    /**
     * Set deleteFlag.
     *
     * @param bool $deleteFlag
     *
     * @return OauthClient
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
}
