<?php

namespace Project\History\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerOperationL
 *
 * @ORM\Table(name="l_customer_operations", indexes={@ORM\Index(name="idx_m_customer_id_lco", columns={"m_customer_id"})})
 * @ORM\Entity
 */
class CustomerOperationL extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="l_customer_operation_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="L顧客アクション履歴ID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $customerOperationLId;

    /**
     * @var int
     *
     * @ORM\Column(name="m_customer_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="M顧客ID"})
     */
    private $mCustomerId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url", type="string", length=128, nullable=true, options={"comment"="URL"})
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=32, nullable=false, options={"comment"="アクション"})
     */
    private $action = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="data", type="text", length=0, nullable=true, options={"comment"="変更内容"})
     */
    private $data;

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
     * Get customerOperationLId.
     *
     * @return int
     */
    public function getCustomerOperationLId()
    {
        return $this->customerOperationLId;
    }

    /**
     * Set mCustomerId.
     *
     * @param int $mCustomerId
     *
     * @return CustomerOperationL
     */
    public function setMCustomerId($mCustomerId)
    {
        $this->mCustomerId = $mCustomerId;

        return $this;
    }

    /**
     * Get mCustomerId.
     *
     * @return int
     */
    public function getMCustomerId()
    {
        return $this->mCustomerId;
    }

    /**
     * Set url.
     *
     * @param string|null $url
     *
     * @return CustomerOperationL
     */
    public function setUrl($url = null)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set action.
     *
     * @param string $action
     *
     * @return CustomerOperationL
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action.
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set data.
     *
     * @param string|null $data
     *
     * @return CustomerOperationL
     */
    public function setData($data = null)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data.
     *
     * @return string|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set createDate.
     *
     * @param \DateTime $createDate
     *
     * @return CustomerOperationL
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
     * @return CustomerOperationL
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
     * @return CustomerOperationL
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
}
