<?php

namespace Project\Inquiry\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inquiry
 *
 * @ORM\Table(name="t_inquiries", indexes={@ORM\Index(name="fk_m_inquiry_type_id_ti", columns={"m_inquiry_type_id"})})
 * @ORM\Entity
 */
class Inquiry extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="t_inquiry_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="T問合せID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inquiryId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="subject", type="string", length=100, nullable=true, options={"comment"="件名"})
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", length=65535, nullable=false, options={"comment"="問合せ内容"})
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=false, options={"comment"="名前"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_sei", type="string", length=30, nullable=false, options={"comment"="名前（姓）"})
     */
    private $nameSei;

    /**
     * @var string
     *
     * @ORM\Column(name="name_mei", type="string", length=30, nullable=false, options={"comment"="名前（名）"})
     */
    private $nameMei;

    /**
     * @var string
     *
     * @ORM\Column(name="kana_sei", type="string", length=30, nullable=false, options={"comment"="カナ（姓）"})
     */
    private $kanaSei;

    /**
     * @var string
     *
     * @ORM\Column(name="kana_mei", type="string", length=30, nullable=false, options={"comment"="カナ（名）"})
     */
    private $kanaMei;

    /**
     * @var string
     *
     * @ORM\Column(name="rental_no", type="string", length=255, nullable=false, options={"comment"="予約番号"})
     */
    private $rentalNo;

    /**
     * @var string
     *
     * @ORM\Column(name="paypal_account", type="string", length=255, nullable=false, options={"comment"="PayPalアカウント"})
     */
    private $paypalAccount;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, nullable=false, options={"comment"="メールアドレス"})
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=16, nullable=false, options={"comment"="電話番号"})
     */
    private $phone;

    /**
     * @var int|null
     *
     * @ORM\Column(name="m_customer_id", type="integer", nullable=true, options={"unsigned"=true,"comment"="M顧客ID(お問合せユーザー)"})
     */
    private $mCustomerId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="m_admin_id", type="integer", nullable=true, options={"unsigned"=true,"comment"="M管理者ID(担当者)"})
     */
    private $mAdminId;

    /**
     * @var bool
     *
     * @ORM\Column(name="process_status", type="integer", nullable=true, options={"comment"="対応状況(ステータス) [1:未対応 2:対応中 3:対応済み 4:対応完了 5:保留 6:対応不要]"})
     */
    private $processStatus;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="process_deadline", type="string", nullable=true, options={"default"="0000-00-00","comment"="対応期日"})
     */
    private $processDeadline = null;

    /**
     * @var bool
     *
     * @ORM\Column(name="process_priority", type="integer", nullable=false, options={"default"="1","comment"="対応優先順[1:高 2:中 3:低]"})
     */
    private $processPriority = '1';

    /**
     * @var string|null
     *
     * @ORM\Column(name="process_comment", type="string", length=1024, nullable=true, options={"comment"="対応内容備考"})
     */
    private $processComment;

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
     * @var \Project\Inquiry\Entity\InquiryType
     *
     * @ORM\ManyToOne(targetEntity="Project\Inquiry\Entity\InquiryType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="m_inquiry_type_id", referencedColumnName="m_inquiry_type_id")
     * })
     */
    private $InquiryType;

    /**
     * @var \Project\Inquiry\Entity\InquiryAction
     *
     * @ORM\ManyToOne(targetEntity="Project\Inquiry\Entity\InquiryAction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="m_inquiry_action_id", referencedColumnName="m_inquiry_action_id")
     * })
     */
    private $InquiryAction;

    /**
     * Get inquiryId.
     *
     * @return int
     */
    public function getInquiryId()
    {
        return $this->inquiryId;
    }

    /**
     * Set subject.
     *
     * @param string|null $subject
     *
     * @return Inquiry
     */
    public function setSubject($subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject.
     *
     * @return string|null
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body.
     *
     * @param string $body
     *
     * @return Inquiry
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
   /**
     * Set body.
     *
     * @param string $name
     *
     * @return Inquiry
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
     * Set nameSei.
     *
     * @param string $nameSei
     *
     * @return Inquiry
     */
    public function setNameSei($nameSei)
    {
        $this->nameSei = $nameSei;

        return $this;
    }

    /**
     * Get nameSei.
     *
     * @return string
     */
    public function getNameSei()
    {
        return $this->nameSei;
    }

    /**
     * Set nameMei.
     *
     * @param string $nameMei
     *
     * @return Inquiry
     */
    public function setNameMei($nameMei)
    {
        $this->nameMei = $nameMei;

        return $this;
    }

    /**
     * Get nameMei.
     *
     * @return string
     */
    public function getNameMei()
    {
        return $this->nameMei;
    }

    /**
     * Set kanaSei.
     *
     * @param string $kanaSei
     *
     * @return Inquiry
     */
    public function setKanaSei($kanaSei)
    {
        $this->kanaSei = $kanaSei;

        return $this;
    }

    /**
     * Get kanaSei.
     *
     * @return string
     */
    public function getKanaSei()
    {
        return $this->kanaSei;
    }

    /**
     * Set kanaMei.
     *
     * @param string $kanaMei
     *
     * @return Inquiry
     */
    public function setKanaMei($kanaMei)
    {
        $this->kanaMei = $kanaMei;

        return $this;
    }

    /**
     * Get kanaMei.
     *
     * @return string
     */
    public function getKanaMei()
    {
        return $this->kanaMei;
    }

    /**
     * Set rentalNo.
     *
     * @param string $rentalNo
     *
     * @return Inquiry
     */
    public function setRentalNo($rentalNo)
    {
        $this->rentalNo = $rentalNo;

        return $this;
    }

    /**
     * Get rentalNo.
     *
     * @return string
     */
    public function getRentalNo()
    {
        return $this->rentalNo;
    }

    /**
     * Set paypalAccount.
     *
     * @param string $paypalAccount
     *
     * @return Inquiry
     */
    public function setPaypalAccount($paypalAccount)
    {
        $this->paypalAccount = $paypalAccount;

        return $this;
    }

    /**
     * Get paypalAccount.
     *
     * @return string
     */
    public function getPaypalAccount()
    {
        return $this->paypalAccount;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Inquiry
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone.
     *
     * @param string $phone
     *
     * @return Inquiry
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set mCustomerId.
     *
     * @param int|null $mCustomerId
     *
     * @return Inquiry
     */
    public function setMCustomerId($mCustomerId = null)
    {
        $this->mCustomerId = $mCustomerId;

        return $this;
    }

    /**
     * Get mCustomerId.
     *
     * @return int|null
     */
    public function getMCustomerId()
    {
        return $this->mCustomerId;
    }

    /**
     * Set mAdminId.
     *
     * @param int|null $mAdminId
     *
     * @return Inquiry
     */
    public function setMAdminId($mAdminId = null)
    {
        $this->mAdminId = $mAdminId;

        return $this;
    }

    /**
     * Get mAdminId.
     *
     * @return int|null
     */
    public function getMAdminId()
    {
        return $this->mAdminId;
    }

    /**
     * Set processStatus.
     *
     * @param bool $processStatus
     *
     * @return Inquiry
     */
    public function setProcessStatus($processStatus)
    {
        $this->processStatus = $processStatus;

        return $this;
    }

    /**
     * Get processStatus.
     *
     * @return bool
     */
    public function getProcessStatus()
    {
        return $this->processStatus;
    }

    /**
     * Set processDeadline.
     *
     * @param \DateTime|null $processDeadline
     *
     * @return Inquiry
     */
    public function setProcessDeadline($processDeadline = null)
    {
        $this->processDeadline = $processDeadline;

        return $this;
    }

    /**
     * Get processDeadline.
     *
     * @return \DateTime|null
     */
    public function getProcessDeadline()
    {
        return $this->processDeadline;
    }

    /**
     * Set processPriority.
     *
     * @param bool $processPriority
     *
     * @return Inquiry
     */
    public function setProcessPriority($processPriority)
    {
        $this->processPriority = $processPriority;

        return $this;
    }

    /**
     * Get processPriority.
     *
     * @return bool
     */
    public function getProcessPriority()
    {
        return $this->processPriority;
    }

    /**
     * Set processComment.
     *
     * @param string|null $processComment
     *
     * @return Inquiry
     */
    public function setProcessComment($processComment = null)
    {
        $this->processComment = $processComment;

        return $this;
    }

    /**
     * Get processComment.
     *
     * @return string|null
     */
    public function getProcessComment()
    {
        return $this->processComment;
    }

    /**
     * Set createDate.
     *
     * @param \DateTime $createDate
     *
     * @return Inquiry
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
     * @return Inquiry
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
     * @return Inquiry
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
     * @return Inquiry
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
     * @return Inquiry
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
     * @return Inquiry
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
     * @return Inquiry
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
     * Set inquiryType.
     *
     * @param \Project\Inquiry\Entity\InquiryType|null $inquiryType
     *
     * @return Inquiry
     */
    public function setInquiryType(\Project\Inquiry\Entity\InquiryType $inquiryType = null)
    {
        $this->InquiryType = $inquiryType;

        return $this;
    }

    /**
     * Get inquiryType.
     *
     * @return \Project\Inquiry\Entity\InquiryType|null
     */
    public function getInquiryType()
    {
        return $this->InquiryType;
    }

    /**
     * Set inquiryAction.
     *
     * @param \Project\Inquiry\Entity\InquiryAction|null $inquiryAction
     *
     * @return Inquiry
     */
    public function setInquiryAction(\Project\Inquiry\Entity\InquiryAction $inquiryAction = null)
    {
        $this->InquiryAction = $inquiryAction;

        return $this;
    }

    /**
     * Get inquiryAction.
     *
     * @return \Project\Inquiry\Entity\InquiryAction|null
     */
    public function getInquiryAction()
    {
        return $this->InquiryAction;
    }
}
