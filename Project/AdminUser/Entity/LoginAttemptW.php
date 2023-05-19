<?php

namespace Project\AdminUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LoginAttemptW
 *
 * @ORM\Table(name="w_login_attempts")
 * @ORM\Entity
 */
class LoginAttemptW extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="w_login_attempt_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $loginAttemptWId;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=45, nullable=false)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=128, nullable=false)
     */
    private $login;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="session_id", type="string", length=128, nullable=false)
     */
    private $sessionId = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_datetime", type="string", nullable=false)
     */
    private $createDatetime = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="create_admin_id", type="integer", nullable=true)
     */
    private $createAdminId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_datetime", type="string", nullable=false)
     */
    private $updateDatetime = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="update_admin_id", type="integer", nullable=true)
     */
    private $updateAdminId;

    /**
     * @var integer
     *
     * @ORM\Column(name="delete_flag", type="integer", nullable=false)
     */
    private $deleteFlag = '0';


    /**
     * Get loginAttemptWId
     *
     * @return integer
     */
    public function getLoginAttemptWId()
    {
        return $this->loginAttemptWId;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return LoginAttemptW
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return LoginAttemptW
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
     * Set status
     *
     * @param integer $status
     *
     * @return LoginAttemptW
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set sessionId
     *
     * @param string $sessionId
     *
     * @return LoginAttemptW
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set createDatetime
     *
     * @param \DateTime $createDatetime
     *
     * @return LoginAttemptW
     */
    public function setCreateDatetime($createDatetime)
    {
        $this->createDatetime = $createDatetime;

        return $this;
    }

    /**
     * Get createDatetime
     *
     * @return \DateTime
     */
    public function getCreateDatetime()
    {
        return $this->createDatetime;
    }

    /**
     * Set createAdminId
     *
     * @param integer $createAdminId
     *
     * @return LoginAttemptW
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
     * Set updateDatetime
     *
     * @param \DateTime $updateDatetime
     *
     * @return LoginAttemptW
     */
    public function setUpdateDatetime($updateDatetime)
    {
        $this->updateDatetime = $updateDatetime;

        return $this;
    }

    /**
     * Get updateDatetime
     *
     * @return \DateTime
     */
    public function getUpdateDatetime()
    {
        return $this->updateDatetime;
    }

    /**
     * Set updateAdminId
     *
     * @param integer $updateAdminId
     *
     * @return LoginAttemptW
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
     * @param integer $deleteFlag
     *
     * @return LoginAttemptW
     */
    public function setDeleteFlag($deleteFlag)
    {
        $this->deleteFlag = $deleteFlag;

        return $this;
    }

    /**
     * Get deleteFlag
     *
     * @return integer
     */
    public function getDeleteFlag()
    {
        return $this->deleteFlag;
    }
}

