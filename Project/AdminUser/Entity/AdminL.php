<?php

namespace Project\AdminUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdminL
 *
 * @ORM\Table(name="l_admins", indexes={@ORM\Index(name="idx_id_type", columns={"m_admin_id", "log_type"}), @ORM\Index(name="IDX_24D9476F6B713468", columns={"m_admin_id"})})
 * @ORM\Entity
 */
class AdminL extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="l_admin_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $adminLId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="log_type", type="integer", nullable=false)
     */
    private $logType = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=64, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="admin_name", type="string", length=64, nullable=true)
     */
    private $adminName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="admin_kana", type="string", length=64, nullable=true)
     */
    private $adminKana;

    /**
     * @var string
     *
     * @ORM\Column(name="admin_password", type="string", length=256, nullable=false)
     */
    private $adminPassword;

    /**
     * @var boolean
     *
     * @ORM\Column(name="temp_password_flag", type="integer", nullable=false)
     */
    private $tempPasswordFlag = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, nullable=true)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login_date", type="string", nullable=true)
     */
    private $lastLoginDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="show_priority", type="integer", nullable=false)
     */
    private $showPriority = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="string", nullable=false)
     */
    private $createDate = '0000-00-00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_time", type="string", nullable=false)
     */
    private $createTime = '00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="create_admin_id", type="integer", nullable=true)
     */
    private $createAdminId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="string", nullable=false)
     */
    private $updateDate = '0000-00-00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="string", nullable=false)
     */
    private $updateTime = '00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="update_admin_id", type="integer", nullable=true)
     */
    private $updateAdminId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="delete_flag", type="integer", nullable=false)
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
     * Get adminLId
     *
     * @return integer
     */
    public function getAdminLId()
    {
        return $this->adminLId;
    }

    /**
     * Set logType
     *
     * @param boolean $logType
     *
     * @return AdminL
     */
    public function setLogType($logType)
    {
        $this->logType = $logType;

        return $this;
    }

    /**
     * Get logType
     *
     * @return boolean
     */
    public function getLogType()
    {
        return $this->logType;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return AdminL
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set adminName
     *
     * @param string $adminName
     *
     * @return AdminL
     */
    public function setAdminName($adminName)
    {
        $this->adminName = $adminName;

        return $this;
    }

    /**
     * Get adminName
     *
     * @return string
     */
    public function getAdminName()
    {
        return $this->adminName;
    }

    /**
     * Set adminKana
     *
     * @param string $adminKana
     *
     * @return AdminL
     */
    public function setAdminKana($adminKana)
    {
        $this->adminKana = $adminKana;

        return $this;
    }

    /**
     * Get adminKana
     *
     * @return string
     */
    public function getAdminKana()
    {
        return $this->adminKana;
    }

    /**
     * Set adminPassword
     *
     * @param string $adminPassword
     *
     * @return AdminL
     */
    public function setAdminPassword($adminPassword)
    {
        $this->adminPassword = $adminPassword;

        return $this;
    }

    /**
     * Get adminPassword
     *
     * @return string
     */
    public function getAdminPassword()
    {
        return $this->adminPassword;
    }

    /**
     * Set tempPasswordFlag
     *
     * @param boolean $tempPasswordFlag
     *
     * @return AdminL
     */
    public function setTempPasswordFlag($tempPasswordFlag)
    {
        $this->tempPasswordFlag = $tempPasswordFlag;

        return $this;
    }

    /**
     * Get tempPasswordFlag
     *
     * @return boolean
     */
    public function getTempPasswordFlag()
    {
        return $this->tempPasswordFlag;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return AdminL
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set lastLoginDate
     *
     * @param \DateTime $lastLoginDate
     *
     * @return AdminL
     */
    public function setLastLoginDate($lastLoginDate)
    {
        $this->lastLoginDate = $lastLoginDate;

        return $this;
    }

    /**
     * Get lastLoginDate
     *
     * @return \DateTime
     */
    public function getLastLoginDate()
    {
        return $this->lastLoginDate;
    }

    /**
     * Set showPriority
     *
     * @param integer $showPriority
     *
     * @return AdminL
     */
    public function setShowPriority($showPriority)
    {
        $this->showPriority = $showPriority;

        return $this;
    }

    /**
     * Get showPriority
     *
     * @return integer
     */
    public function getShowPriority()
    {
        return $this->showPriority;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return AdminL
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return AdminL
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set createAdminId
     *
     * @param integer $createAdminId
     *
     * @return AdminL
     */
    public function setCreateAdminId($createAdminId)
    {
        $this->createAdminId = $createAdminId;

        return $this;
    }

    /**
     * Get createAdminId
     *
     * @return integer
     */
    public function getCreateAdminId()
    {
        return $this->createAdminId;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return AdminL
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set updateTime
     *
     * @param \DateTime $updateTime
     *
     * @return AdminL
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return \DateTime
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set updateAdminId
     *
     * @param integer $updateAdminId
     *
     * @return AdminL
     */
    public function setUpdateAdminId($updateAdminId)
    {
        $this->updateAdminId = $updateAdminId;

        return $this;
    }

    /**
     * Get updateAdminId
     *
     * @return integer
     */
    public function getUpdateAdminId()
    {
        return $this->updateAdminId;
    }

    /**
     * Set deleteFlag
     *
     * @param boolean $deleteFlag
     *
     * @return AdminL
     */
    public function setDeleteFlag($deleteFlag)
    {
        $this->deleteFlag = $deleteFlag;

        return $this;
    }

    /**
     * Get deleteFlag
     *
     * @return boolean
     */
    public function getDeleteFlag()
    {
        return $this->deleteFlag;
    }

    /**
     * Set admin
     *
     * @param \Project\AdminUser\Entity\Admin $admin
     *
     * @return AdminL
     */
    public function setAdmin(\Project\AdminUser\Entity\Admin $admin = null)
    {
        $this->Admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return \Project\AdminUser\Entity\Admin
     */
    public function getAdmin()
    {
        return $this->Admin;
    }
}

