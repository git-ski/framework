<?php

namespace Project\Base\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prefecture
 *
 * @ORM\Table(name="m_prefectures")
 * @ORM\Entity
 */
class Prefecture extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="m_prefecture_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prefectureId;

    /**
     * @var string
     *
     * @ORM\Column(name="prefecture_name", type="string", length=16, nullable=true)
     */
    private $prefectureName;

    /**
     * @var string
     *
     * @ORM\Column(name="roman_name", type="string", length=30, nullable=true)
     */
    private $romanName;

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
     * Get prefectureId
     *
     * @return integer
     */
    public function getPrefectureId()
    {
        return $this->prefectureId;
    }

    /**
     * Set prefectureName
     *
     * @param string $prefectureName
     *
     * @return Prefecture
     */
    public function setPrefectureName($prefectureName)
    {
        $this->prefectureName = $prefectureName;

        return $this;
    }

    /**
     * Get prefectureName
     *
     * @return string
     */
    public function getPrefectureName()
    {
        return $this->prefectureName;
    }

    /**
     * Set romanName
     *
     * @param string $romanName
     *
     * @return Prefecture
     */
    public function setRomanName($romanName)
    {
        $this->romanName = $romanName;

        return $this;
    }

    /**
     * Get romanName
     *
     * @return string
     */
    public function getRomanName()
    {
        return $this->romanName;
    }

    /**
     * Set showPriority
     *
     * @param integer $showPriority
     *
     * @return Prefecture
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
     * @return Prefecture
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
     * @return Prefecture
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
     * @return Prefecture
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
     * @return Prefecture
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
     * @return Prefecture
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
     * @return Prefecture
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
     * @return Prefecture
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
}
