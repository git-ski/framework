<?php

namespace Project\Base\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ZipcodeJa
 *
 * @ORM\Table(name="m_zipcodes_ja", indexes={@ORM\Index(name="m_zipcode_idx1", columns={"zip_cd"}), @ORM\Index(name="fk_m_prefecture_id_mz", columns={"m_prefecture_id"})})
 * @ORM\Entity
 */
class ZipcodeJa extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="m_zipcode_ja_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="M郵便番号日本ID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $zipcodeJaId;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_cd", type="string", length=7, nullable=false, options={"comment"="郵便番号"})
     */
    private $zipCd;

    /**
     * @var int
     *
     * @ORM\Column(name="m_prefecture_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="M都道府県ID"})
     */
    private $mPrefectureId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address01", type="string", length=100, nullable=true, options={"comment"="市区町村"})
     */
    private $address01;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address02", type="string", length=100, nullable=true, options={"comment"="番地"})
     */
    private $address02;

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
     * @var bool
     *
     * @ORM\Column(name="delete_flag", type="integer", nullable=false, options={"comment"="削除フラグ [0:未削除 1:削除済み]"})
     */
    private $deleteFlag = '0';


    /**
     * Get zipcodeJaId.
     *
     * @return int
     */
    public function getZipcodeJaId()
    {
        return $this->zipcodeJaId;
    }

    /**
     * Set zipCd.
     *
     * @param string $zipCd
     *
     * @return ZipcodeJa
     */
    public function setZipCd($zipCd)
    {
        $this->zipCd = $zipCd;

        return $this;
    }

    /**
     * Get zipCd.
     *
     * @return string
     */
    public function getZipCd()
    {
        return $this->zipCd;
    }

    /**
     * Set mPrefectureId.
     *
     * @param int $mPrefectureId
     *
     * @return ZipcodeJa
     */
    public function setMPrefectureId($mPrefectureId)
    {
        $this->mPrefectureId = $mPrefectureId;

        return $this;
    }

    /**
     * Get mPrefectureId.
     *
     * @return int
     */
    public function getMPrefectureId()
    {
        return $this->mPrefectureId;
    }

    /**
     * Set address01.
     *
     * @param string|null $address01
     *
     * @return ZipcodeJa
     */
    public function setAddress01($address01 = null)
    {
        $this->address01 = $address01;

        return $this;
    }

    /**
     * Get address01.
     *
     * @return string|null
     */
    public function getAddress01()
    {
        return $this->address01;
    }

    /**
     * Set address02.
     *
     * @param string|null $address02
     *
     * @return ZipcodeJa
     */
    public function setAddress02($address02 = null)
    {
        $this->address02 = $address02;

        return $this;
    }

    /**
     * Get address02.
     *
     * @return string|null
     */
    public function getAddress02()
    {
        return $this->address02;
    }

    /**
     * Set createDate.
     *
     * @param \DateTime $createDate
     *
     * @return ZipcodeJa
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
     * @return ZipcodeJa
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
     * @return ZipcodeJa
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
     * @return ZipcodeJa
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
     * @return ZipcodeJa
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
     * @return ZipcodeJa
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
     * @return ZipcodeJa
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
