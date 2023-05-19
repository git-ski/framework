<?php

namespace Project\Customer\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="m_customers", indexes={@ORM\Index(name="fk_m_prefecture_id_01_mc", columns={"m_prefecture_id"}), @ORM\Index(name="fk_m_country_id_01_mc", columns={"m_country_id"})})
 * @ORM\Entity
 */
class Customer extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="m_customer_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="M顧客ID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $customerId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="customer_no", type="string", length=32, nullable=true, options={"comment"="会員番号"})
     */
    private $customerNo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="login", type="string", length=128, nullable=true, options={"comment"="会員ID（ログインID）"})
     */
    private $login;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name_sei", type="string", length=64, nullable=true, options={"comment"="名前（姓）"})
     */
    private $nameSei;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name_mei", type="string", length=64, nullable=true, options={"comment"="名前（名）"})
     */
    private $nameMei;

    /**
     * @var string|null
     *
     * @ORM\Column(name="kana_sei", type="string", length=64, nullable=true, options={"comment"="カナ（姓）"})
     */
    private $kanaSei;

    /**
     * @var string|null
     *
     * @ORM\Column(name="kana_mei", type="string", length=64, nullable=true, options={"comment"="カナ（名）"})
     */
    private $kanaMei;

    /**
     * @var string|null
     *
     * @ORM\Column(name="customer_password", type="string", length=256, nullable=true, options={"comment"="パスワード"})
     */
    private $customerPassword;

    /**
     * @var bool
     *
     * @ORM\Column(name="temp_password_flag", type="integer", nullable=false, options={"default"="1","comment"="仮パスワードフラグ"})
     */
    private $tempPasswordFlag = '1';

    /**
     * @var string|null
     *
     * @ORM\Column(name="zip_cd", type="string", length=16, nullable=true, options={"comment"="郵便番号"})
     */
    private $zipCd;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address01", type="string", length=256, nullable=true, options={"comment"="市区町村"})
     */
    private $address01;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address02", type="string", length=256, nullable=true, options={"comment"="番地"})
     */
    private $address02;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address03", type="string", length=256, nullable=true, options={"comment"="建物名"})
     */
    private $address03;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=128, nullable=true, options={"comment"="PCメールアドレス"})
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=16, nullable=true, options={"comment"="電話番号"})
     */
    private $phone;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="birth_date", type="string", nullable=true, options={"comment"="生年月日"})
     */
    private $birthDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sex_type_id", type="integer", nullable=true, options={"unsigned"=true,"comment"="性別ID（M語彙詳細ID）"})
     */
    private $sexTypeId;

    /**
     * @var bool
     *
     * @ORM\Column(name="mailmagazine_receive_flag", type="integer", nullable=false, options={"comment"="メルマガ受信フラグ[0:拒否 1:受信]"})
     */
    private $mailmagazineReceiveFlag = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="member_register_date", type="string", nullable=true, options={"comment"="会員登録日"})
     */
    private $memberRegisterDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="member_withdraw_date", type="string", nullable=true, options={"comment"="会員退会日"})
     */
    private $memberWithdrawDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="withdraw_reason", type="string", length=512, nullable=true, options={"comment"="退会理由"})
     */
    private $withdrawReason;

    /**
     * @var string|null
     *
     * @ORM\Column(name="withdraw_note", type="string", length=512, nullable=true, options={"comment"="退会時備考"})
     */
    private $withdrawNote;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_logint_datetime", type="string", nullable=true, options={"comment"="最終ログイン日時"})
     */
    private $lastLogintDatetime;

    /**
     * @var bool
     *
     * @ORM\Column(name="default_language", type="integer", nullable=false, options={"default"="1","comment"="デフォルト言語[1:ja 2:en]"})
     */
    private $defaultLanguage = '1';

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
     * @var \Project\Base\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="Project\Base\Entity\Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="m_country_id", referencedColumnName="m_country_id")
     * })
     */
    private $Country;

    /**
     * @var \Project\Base\Entity\Prefecture
     *
     * @ORM\ManyToOne(targetEntity="Project\Base\Entity\Prefecture")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="m_prefecture_id", referencedColumnName="m_prefecture_id")
     * })
     */
    private $Prefecture;


    /**
     * Get customerId.
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set customerNo.
     *
     * @param string|null $customerNo
     *
     * @return Customer
     */
    public function setCustomerNo($customerNo = null)
    {
        $this->customerNo = $customerNo;

        return $this;
    }

    /**
     * Get customerNo.
     *
     * @return string|null
     */
    public function getCustomerNo()
    {
        return $this->customerNo;
    }

    /**
     * Set login.
     *
     * @param string|null $login
     *
     * @return Customer
     */
    public function setLogin($login = null)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login.
     *
     * @return string|null
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set nameSei.
     *
     * @param string|null $nameSei
     *
     * @return Customer
     */
    public function setNameSei($nameSei = null)
    {
        $this->nameSei = $nameSei;

        return $this;
    }

    /**
     * Get nameSei.
     *
     * @return string|null
     */
    public function getNameSei()
    {
        return $this->nameSei;
    }

    /**
     * Set nameMei.
     *
     * @param string|null $nameMei
     *
     * @return Customer
     */
    public function setNameMei($nameMei = null)
    {
        $this->nameMei = $nameMei;

        return $this;
    }

    /**
     * Get nameMei.
     *
     * @return string|null
     */
    public function getNameMei()
    {
        return $this->nameMei;
    }

    /**
     * Set kanaSei.
     *
     * @param string|null $kanaSei
     *
     * @return Customer
     */
    public function setKanaSei($kanaSei = null)
    {
        $this->kanaSei = $kanaSei;

        return $this;
    }

    /**
     * Get kanaSei.
     *
     * @return string|null
     */
    public function getKanaSei()
    {
        return $this->kanaSei;
    }

    /**
     * Set kanaMei.
     *
     * @param string|null $kanaMei
     *
     * @return Customer
     */
    public function setKanaMei($kanaMei = null)
    {
        $this->kanaMei = $kanaMei;

        return $this;
    }

    /**
     * Get kanaMei.
     *
     * @return string|null
     */
    public function getKanaMei()
    {
        return $this->kanaMei;
    }

    /**
     * Set customerPassword.
     *
     * @param string|null $customerPassword
     *
     * @return Customer
     */
    public function setCustomerPassword($customerPassword = null)
    {
        $this->customerPassword = $customerPassword;

        return $this;
    }

    /**
     * Get customerPassword.
     *
     * @return string|null
     */
    public function getCustomerPassword()
    {
        return $this->customerPassword;
    }

    /**
     * Set tempPasswordFlag.
     *
     * @param bool $tempPasswordFlag
     *
     * @return Customer
     */
    public function setTempPasswordFlag($tempPasswordFlag)
    {
        $this->tempPasswordFlag = $tempPasswordFlag;

        return $this;
    }

    /**
     * Get tempPasswordFlag.
     *
     * @return bool
     */
    public function getTempPasswordFlag()
    {
        return $this->tempPasswordFlag;
    }

    /**
     * Set zipCd.
     *
     * @param string|null $zipCd
     *
     * @return Customer
     */
    public function setZipCd($zipCd = null)
    {
        $this->zipCd = $zipCd;

        return $this;
    }

    /**
     * Get zipCd.
     *
     * @return string|null
     */
    public function getZipCd()
    {
        return $this->zipCd;
    }

    /**
     * Set address01.
     *
     * @param string|null $address01
     *
     * @return Customer
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
     * @return Customer
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
     * Set address03.
     *
     * @param string|null $address03
     *
     * @return Customer
     */
    public function setAddress03($address03 = null)
    {
        $this->address03 = $address03;

        return $this;
    }

    /**
     * Get address03.
     *
     * @return string|null
     */
    public function getAddress03()
    {
        return $this->address03;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return Customer
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone.
     *
     * @param string|null $phone
     *
     * @return Customer
     */
    public function setPhone($phone = null)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set birthDate.
     *
     * @param \DateTime|null $birthDate
     *
     * @return Customer
     */
    public function setBirthDate($birthDate = null)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate.
     *
     * @return \DateTime|null
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set sexTypeId.
     *
     * @param int|null $sexTypeId
     *
     * @return Customer
     */
    public function setSexTypeId($sexTypeId = null)
    {
        $this->sexTypeId = $sexTypeId;

        return $this;
    }

    /**
     * Get sexTypeId.
     *
     * @return int|null
     */
    public function getSexTypeId()
    {
        return $this->sexTypeId;
    }

    /**
     * Set mailmagazineReceiveFlag.
     *
     * @param bool $mailmagazineReceiveFlag
     *
     * @return Customer
     */
    public function setMailmagazineReceiveFlag($mailmagazineReceiveFlag)
    {
        $this->mailmagazineReceiveFlag = $mailmagazineReceiveFlag;

        return $this;
    }

    /**
     * Get mailmagazineReceiveFlag.
     *
     * @return bool
     */
    public function getMailmagazineReceiveFlag()
    {
        return $this->mailmagazineReceiveFlag;
    }

    /**
     * Set memberRegisterDate.
     *
     * @param \DateTime|null $memberRegisterDate
     *
     * @return Customer
     */
    public function setMemberRegisterDate($memberRegisterDate = null)
    {
        $this->memberRegisterDate = $memberRegisterDate;

        return $this;
    }

    /**
     * Get memberRegisterDate.
     *
     * @return \DateTime|null
     */
    public function getMemberRegisterDate()
    {
        return $this->memberRegisterDate;
    }

    /**
     * Set memberWithdrawDate.
     *
     * @param \DateTime|null $memberWithdrawDate
     *
     * @return Customer
     */
    public function setMemberWithdrawDate($memberWithdrawDate = null)
    {
        $this->memberWithdrawDate = $memberWithdrawDate;

        return $this;
    }

    /**
     * Get memberWithdrawDate.
     *
     * @return \DateTime|null
     */
    public function getMemberWithdrawDate()
    {
        return $this->memberWithdrawDate;
    }

    /**
     * Set withdrawReason.
     *
     * @param string|null $withdrawReason
     *
     * @return Customer
     */
    public function setWithdrawReason($withdrawReason = null)
    {
        $this->withdrawReason = $withdrawReason;

        return $this;
    }

    /**
     * Get withdrawReason.
     *
     * @return string|null
     */
    public function getWithdrawReason()
    {
        return $this->withdrawReason;
    }

    /**
     * Set withdrawNote.
     *
     * @param string|null $withdrawNote
     *
     * @return Customer
     */
    public function setWithdrawNote($withdrawNote = null)
    {
        $this->withdrawNote = $withdrawNote;

        return $this;
    }

    /**
     * Get withdrawNote.
     *
     * @return string|null
     */
    public function getWithdrawNote()
    {
        return $this->withdrawNote;
    }

    /**
     * Set lastLogintDatetime.
     *
     * @param \DateTime|null $lastLogintDatetime
     *
     * @return Customer
     */
    public function setLastLogintDatetime($lastLogintDatetime = null)
    {
        $this->lastLogintDatetime = $lastLogintDatetime;

        return $this;
    }

    /**
     * Get lastLogintDatetime.
     *
     * @return \DateTime|null
     */
    public function getLastLogintDatetime()
    {
        return $this->lastLogintDatetime;
    }

    /**
     * Set defaultLanguage.
     *
     * @param bool $defaultLanguage
     *
     * @return Customer
     */
    public function setDefaultLanguage($defaultLanguage)
    {
        $this->defaultLanguage = $defaultLanguage;

        return $this;
    }

    /**
     * Get defaultLanguage.
     *
     * @return bool
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    /**
     * Set createDate.
     *
     * @param \DateTime $createDate
     *
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * Set country.
     *
     * @param \Project\Base\Entity\Country|null $country
     *
     * @return Customer
     */
    public function setCountry(\Project\Base\Entity\Country $country = null)
    {
        $this->Country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return \Project\Base\Entity\Country|null
     */
    public function getCountry()
    {
        return $this->Country;
    }

    /**
     * Set prefecture.
     *
     * @param \Project\Base\Entity\Prefecture|null $prefecture
     *
     * @return Customer
     */
    public function setPrefecture(\Project\Base\Entity\Prefecture $prefecture = null)
    {
        $this->Prefecture = $prefecture;

        return $this;
    }

    /**
     * Get prefecture.
     *
     * @return \Project\Base\Entity\Prefecture|null
     */
    public function getPrefecture()
    {
        return $this->Prefecture;
    }
}
