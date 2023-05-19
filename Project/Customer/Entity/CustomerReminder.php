<?php

namespace Project\Customer\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerReminder
 *
 * @ORM\Table(name="w_customer_reminders", indexes={@ORM\Index(name="fk_m_customer_id_wcr", columns={"m_customer_id"})})
 * @ORM\Entity
 */
class CustomerReminder extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="w_customer_reminder_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $customerReminderId;

    /**
     * @var binary
     *
     * @ORM\Column(name="url_hash_key", type="binary", nullable=false)
     */
    private $urlHashKey;

    /**
     * @var binary
     *
     * @ORM\Column(name="verify_hash_key", type="binary", nullable=false)
     */
    private $verifyHashKey;

    /**
     * @var boolean
     *
     * @ORM\Column(name="use_flag", type="integer", nullable=true)
     */
    private $useFlag = '0';

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
     * @var \Project\Customer\Entity\Customer
     *
     * @ORM\ManyToOne(targetEntity="Project\Customer\Entity\Customer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="m_customer_id", referencedColumnName="m_customer_id")
     * })
     */
    private $Customer;


    /**
     * Get customerReminderId
     *
     * @return integer
     */
    public function getCustomerReminderId()
    {
        return $this->customerReminderId;
    }

    /**
     * Set urlHashKey
     *
     * @param binary $urlHashKey
     *
     * @return CustomerReminder
     */
    public function setUrlHashKey($urlHashKey)
    {
        $this->urlHashKey = $urlHashKey;

        return $this;
    }

    /**
     * Get urlHashKey
     *
     * @return binary
     */
    public function getUrlHashKey()
    {
        return $this->urlHashKey;
    }

    /**
     * Set verifyHashKey
     *
     * @param binary $verifyHashKey
     *
     * @return CustomerReminder
     */
    public function setVerifyHashKey($verifyHashKey)
    {
        $this->verifyHashKey = $verifyHashKey;

        return $this;
    }

    /**
     * Get verifyHashKey
     *
     * @return binary
     */
    public function getVerifyHashKey()
    {
        return $this->verifyHashKey;
    }

    /**
     * Set useFlag
     *
     * @param boolean $useFlag
     *
     * @return CustomerReminder
     */
    public function setUseFlag($useFlag)
    {
        $this->useFlag = $useFlag;

        return $this;
    }

    /**
     * Get useFlag
     *
     * @return boolean
     */
    public function getUseFlag()
    {
        return $this->useFlag;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return CustomerReminder
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
     * @return CustomerReminder
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
     * @return CustomerReminder
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
     * @return CustomerReminder
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
     * @return CustomerReminder
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
     * @return CustomerReminder
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
     * @return CustomerReminder
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
     * Set customer
     *
     * @param \Project\Customer\Entity\Customer $customer
     *
     * @return CustomerReminder
     */
    public function setCustomer(\Project\Customer\Entity\Customer $customer = null)
    {
        $this->Customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Project\Customer\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->Customer;
    }
}

