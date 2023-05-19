<?php

namespace Project\Inquiry\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InquiryAction
 *
 * @ORM\Table(name="m_inquiry_actions", indexes={@ORM\Index(name="k_action_mit", columns={"action"})})
 * @ORM\Entity
 */
class InquiryAction extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="m_inquiry_action_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="MアクションID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inquiryActionId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="action", type="string", length=128, nullable=true, options={"comment"="アクション"})
     */
    private $action;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true, options={"comment"="アクション説明"})
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="show_priority", type="integer", nullable=false, options={"default"="1","unsigned"=true,"comment"="表示順"})
     */
    private $showPriority = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="string", nullable=false, options={"default"="0000-00-00","comment"="作成日"})
     */
    private $createDate = '0000-00-00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_time", type="string", nullable=false, options={"default"="00:00:00","comment"="作成時"})
     */
    private $createTime = '00:00:00';

    /**
     * @var int|null
     *
     * @ORM\Column(name="create_admin_id", type="integer", nullable=true, options={"unsigned"=true,"comment"="作成管理ユーザーID"})
     */
    private $createAdminId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="string", nullable=false, options={"default"="0000-00-00","comment"="更新日時"})
     */
    private $updateDate = '0000-00-00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="string", nullable=false, options={"default"="00:00:00","comment"="更新時"})
     */
    private $updateTime = '00:00:00';

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
     * Get inquiryActionId.
     *
     * @return int
     */
    public function getInquiryActionId()
    {
        return $this->inquiryActionId;
    }

    /**
     * Set action.
     *
     * @param string|null $action
     *
     * @return InquiryAction
     */
    public function setAction($action = null)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action.
     *
     * @return string|null
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return InquiryAction
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set showPriority.
     *
     * @param int $showPriority
     *
     * @return InquiryAction
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
     * @return InquiryAction
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
     * @return InquiryAction
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
     * @return InquiryAction
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
     * @return InquiryAction
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
     * @return InquiryAction
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
     * @return InquiryAction
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
     * @return InquiryAction
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
