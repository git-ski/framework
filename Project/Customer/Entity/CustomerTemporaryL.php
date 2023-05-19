<?php

namespace Project\Customer\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerTemporaryL
 *
 * @ORM\Table(name="l_customer_temporaries")
 * @ORM\Entity
 */
class CustomerTemporaryL extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="l_customer_temporary_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $customerTemporaryLId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="url_hash_key", type="string", length=255, nullable=false)
     */
    private $urlHashKey;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=256, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="redirect_to", type="string", length=255, nullable=true)
     */
    private $redirectTo;

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
     * Get customerTemporaryLId
     *
     * @return integer
     */
    public function getCustomerTemporaryLId()
    {
        return $this->customerTemporaryLId;
    }

    /**
     * Set type
     *
     * @param boolean $type
     *
     * @return CustomerTemporaryL
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return boolean
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set urlHashKey
     *
     * @param string $urlHashKey
     *
     * @return CustomerTemporaryL
     */
    public function setUrlHashKey($urlHashKey)
    {
        $this->urlHashKey = $urlHashKey;

        return $this;
    }

    /**
     * Get urlHashKey
     *
     * @return string
     */
    public function getUrlHashKey()
    {
        return $this->urlHashKey;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return CustomerTemporaryL
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
     * Set redirectTo
     *
     * @param string $redirectTo
     *
     * @return CustomerTemporaryL
     */
    public function setRedirectTo($redirectTo)
    {
        $this->redirectTo = $redirectTo;

        return $this;
    }

    /**
     * Get redirectTo
     *
     * @return string
     */
    public function getRedirectTo()
    {
        return $this->redirectTo;
    }

    /**
     * Set useFlag
     *
     * @param boolean $useFlag
     *
     * @return CustomerTemporaryL
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
     * @return CustomerTemporaryL
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
     * @return CustomerTemporaryL
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
}

