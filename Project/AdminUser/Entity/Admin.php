<?php

namespace Project\AdminUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin
 *
 * @ORM\Table(name="m_admins", indexes={@ORM\Index(name="ik_login", columns={"login", "delete_flag"})})
 * @ORM\Entity
 */
class Admin extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="m_admin_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="M管理者ID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $adminId;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=30, nullable=false, options={"comment"="管理者ID"})
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="admin_name", type="string", length=30, nullable=false, options={"comment"="管理者名"})
     */
    private $adminName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="admin_kana", type="string", length=30, nullable=true, options={"comment"="管理者名（カナ）"})
     */
    private $adminKana;

    /**
     * @var string|null
     *
     * @ORM\Column(name="avatar", type="string", length=64, nullable=true, options={"comment"="アバター"})
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="admin_password", type="string", length=256, nullable=false, options={"comment"="管理者パスワード"})
     */
    private $adminPassword;

    /**
     * @var bool
     *
     * @ORM\Column(name="temp_password_flag", type="integer", nullable=false, options={"default"="1","comment"="仮パスワードフラグ"})
     */
    private $tempPasswordFlag = '1';

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=128, nullable=true, options={"comment"="管理者メールアドレス"})
     */
    private $email;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_login_date", type="string", nullable=true, options={"comment"="最終ログイン日"})
     */
    private $lastLoginDate;

    /**
     * @var int
     *
     * @ORM\Column(name="show_priority", type="integer", nullable=false, options={"default"="1","unsigned"=true,"comment"="表示順"})
     */
    private $showPriority = '1';

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
     * Get adminId.
     *
     * @return int
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * Set login.
     *
     * @param string $login
     *
     * @return Admin
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set adminName.
     *
     * @param string $adminName
     *
     * @return Admin
     */
    public function setAdminName($adminName)
    {
        $this->adminName = $adminName;

        return $this;
    }

    /**
     * Get adminName.
     *
     * @return string
     */
    public function getAdminName()
    {
        return $this->adminName;
    }

    /**
     * Set adminKana.
     *
     * @param string|null $adminKana
     *
     * @return Admin
     */
    public function setAdminKana($adminKana = null)
    {
        $this->adminKana = $adminKana;

        return $this;
    }

    /**
     * Get adminKana.
     *
     * @return string|null
     */
    public function getAdminKana()
    {
        return $this->adminKana;
    }

    /**
     * Set avatar.
     *
     * @param string|null $avatar
     *
     * @return Admin
     */
    public function setAvatar($avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar.
     *
     * @return string|null
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set adminPassword.
     *
     * @param string $adminPassword
     *
     * @return Admin
     */
    public function setAdminPassword($adminPassword)
    {
        $this->adminPassword = $adminPassword;

        return $this;
    }

    /**
     * Get adminPassword.
     *
     * @return string
     */
    public function getAdminPassword()
    {
        return $this->adminPassword;
    }

    /**
     * Set tempPasswordFlag.
     *
     * @param bool $tempPasswordFlag
     *
     * @return Admin
     */
    public function setTempPasswordFlag($tempPasswordFlag)
    {
        $this->tempPasswordFlag = $tempPasswordFlag;

        return $this;
    }

    /**
     * Get tempPasswordFlag.
     *
     * @return bool
     */
    public function getTempPasswordFlag()
    {
        return $this->tempPasswordFlag;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return Admin
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set lastLoginDate.
     *
     * @param \DateTime|null $lastLoginDate
     *
     * @return Admin
     */
    public function setLastLoginDate($lastLoginDate = null)
    {
        $this->lastLoginDate = $lastLoginDate;

        return $this;
    }

    /**
     * Get lastLoginDate.
     *
     * @return \DateTime|null
     */
    public function getLastLoginDate()
    {
        return $this->lastLoginDate;
    }

    /**
     * Set showPriority.
     *
     * @param int $showPriority
     *
     * @return Admin
     */
    public function setShowPriority($showPriority)
    {
        $this->showPriority = $showPriority;

        return $this;
    }

    /**
     * Get showPriority.
     *
     * @return int
     */
    public function getShowPriority()
    {
        return $this->showPriority;
    }

    /**
     * Set createDate.
     *
     * @param \DateTime $createDate
     *
     * @return Admin
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
     * @return Admin
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
     * @return Admin
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
     * @return Admin
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
     * @return Admin
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
     * @return Admin
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
     * @return Admin
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
