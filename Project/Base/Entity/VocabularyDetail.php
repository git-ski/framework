<?php

namespace Project\Base\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VocabularyDetail
 *
 * @ORM\Table(name="m_vocabulary_details", uniqueConstraints={@ORM\UniqueConstraint(name="m_vocabulary_header_id_machine_name", columns={"m_vocabulary_header_id", "machine_name"})}, indexes={@ORM\Index(name="vocabulary_tree", columns={"m_vocabulary_header_id", "show_priority", "name"}), @ORM\Index(name="m_vocabulary_header_id_name", columns={"m_vocabulary_header_id", "name"}), @ORM\Index(name="name", columns={"name"}), @ORM\Index(name="machine_name", columns={"machine_name"}), @ORM\Index(name="IDX_A9F03E6E425836C5", columns={"m_vocabulary_header_id"})})
 * @ORM\Entity
 */
class VocabularyDetail extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="m_vocabulary_detail_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="M語彙詳細ID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $vocabularyDetailId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="machine_name", type="string", length=255, nullable=true, options={"comment"="語彙名(システム用、登録のみ)"})
     */
    private $machineName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false, options={"comment"="語彙名"})
     */
    private $name = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", length=0, nullable=true, options={"comment"="コメント"})
     */
    private $comment;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_flag", type="integer", nullable=false, options={"comment"="表示フラグ [0:非表示 1:表示]"})
     */
    private $displayFlag = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="show_priority", type="integer", nullable=false, options={"comment"="表示順"})
     */
    private $showPriority = '0';

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
     * @var \Project\Base\Entity\VocabularyHeader
     *
     * @ORM\ManyToOne(targetEntity="Project\Base\Entity\VocabularyHeader")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="m_vocabulary_header_id", referencedColumnName="m_vocabulary_header_id")
     * })
     */
    private $VocabularyHeader;


    /**
     * Get vocabularyDetailId.
     *
     * @return int
     */
    public function getVocabularyDetailId()
    {
        return $this->vocabularyDetailId;
    }

    /**
     * Set machineName.
     *
     * @param string|null $machineName
     *
     * @return VocabularyDetail
     */
    public function setMachineName($machineName = null)
    {
        $this->machineName = $machineName;

        return $this;
    }

    /**
     * Get machineName.
     *
     * @return string|null
     */
    public function getMachineName()
    {
        return $this->machineName;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return VocabularyDetail
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
     * Set comment.
     *
     * @param string|null $comment
     *
     * @return VocabularyDetail
     */
    public function setComment($comment = null)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string|null
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set displayFlag.
     *
     * @param bool $displayFlag
     *
     * @return VocabularyDetail
     */
    public function setDisplayFlag($displayFlag)
    {
        $this->displayFlag = $displayFlag;

        return $this;
    }

    /**
     * Get displayFlag.
     *
     * @return bool
     */
    public function getDisplayFlag()
    {
        return $this->displayFlag;
    }

    /**
     * Set showPriority.
     *
     * @param int $showPriority
     *
     * @return VocabularyDetail
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
     * @return VocabularyDetail
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
     * @return VocabularyDetail
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
     * @return VocabularyDetail
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
     * @return VocabularyDetail
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
     * @return VocabularyDetail
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
     * @return VocabularyDetail
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
     * Set vocabularyHeader.
     *
     * @param \Project\Base\Entity\VocabularyHeader|null $vocabularyHeader
     *
     * @return VocabularyDetail
     */
    public function setVocabularyHeader(\Project\Base\Entity\VocabularyHeader $vocabularyHeader = null)
    {
        $this->VocabularyHeader = $vocabularyHeader;

        return $this;
    }

    /**
     * Get vocabularyHeader.
     *
     * @return \Project\Base\Entity\VocabularyHeader|null
     */
    public function getVocabularyHeader()
    {
        return $this->VocabularyHeader;
    }
}
