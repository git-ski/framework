<?php

namespace Project\Base\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VocabularyHeader
 *
 * @ORM\Table(name="m_vocabulary_headers", uniqueConstraints={@ORM\UniqueConstraint(name="machine_name", columns={"machine_name"})}, indexes={@ORM\Index(name="list", columns={"show_priority", "name"})})
 * @ORM\Entity
 */
class VocabularyHeader extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="m_vocabulary_header_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="M語彙ヘッダーID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $vocabularyHeaderId;

    /**
     * @var string
     *
     * @ORM\Column(name="machine_name", type="string", length=255, nullable=false, options={"comment"="語彙グループ名(システム用、登録のみ)"})
     */
    private $machineName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false, options={"comment"="語彙グループ名"})
     */
    private $name = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", length=0, nullable=true, options={"comment"="コメント"})
     */
    private $comment;

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
     * Get vocabularyHeaderId.
     *
     * @return int
     */
    public function getVocabularyHeaderId()
    {
        return $this->vocabularyHeaderId;
    }

    /**
     * Set machineName.
     *
     * @param string $machineName
     *
     * @return VocabularyHeader
     */
    public function setMachineName($machineName)
    {
        $this->machineName = $machineName;

        return $this;
    }

    /**
     * Get machineName.
     *
     * @return string
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
     * @return VocabularyHeader
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
     * @return VocabularyHeader
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
     * Set showPriority.
     *
     * @param int $showPriority
     *
     * @return VocabularyHeader
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
     * @return VocabularyHeader
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
     * @return VocabularyHeader
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
     * @return VocabularyHeader
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
     * @return VocabularyHeader
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
     * @return VocabularyHeader
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
     * @return VocabularyHeader
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
}
