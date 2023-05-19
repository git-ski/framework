<?php
namespace Project\Customer\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * CustomerL
 *
 * @ORM\Table(name="l_customers", indexes={@ORM\Index(name="fk_m_customer_id_lc", columns={"m_customer_id"})})
 * @ORM\Entity
 */
class CustomerL extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="l_customer_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="L顧客履歴ID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $customerLId;
    /**
     * @var bool
     *
     * @ORM\Column(name="log_type", type="integer", nullable=false, options={"default"="1","comment"="履歴タイプ[1: 顧客情報変更 2: パスワード変更]"})
     */
    private $logType = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=30, nullable=false, options={"comment"="顧客ID"})
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
     * @var int|null
     *
     * @ORM\Column(name="m_prefecture_id", type="integer", nullable=true, options={"unsigned"=true,"comment"="M都道府県マスタID"})
     */
    private $mPrefectureId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zip_cd", type="string", length=7, nullable=true, options={"comment"="郵便番号"})
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
     * @var \Project\Customer\Entity\Customer
     *
     * @ORM\ManyToOne(targetEntity="Project\Customer\Entity\Customer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="m_customer_id", referencedColumnName="m_customer_id")
     * })
     */
    private $Customer;


    /**
     * Get customerLId.
     *
     * @return int
     */
    public function getCustomerLId()
    {
        return $this->customerLId;
    }

    /**
     * Set logType.
     *
     * @param bool $logType
     *
     * @return CustomerL
     */
    public function setLogType($logType)
    {
        $this->logType = $logType;

        return $this;
    }

    /**
     * Get logType.
     *
     * @return bool
     */
    public function getLogType()
    {
        return $this->logType;
    }

    /**
     * Set login.
     *
     * @param string $login
     *
     * @return CustomerL
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login.
     *
     * @return string
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
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * Set mPrefectureId.
     *
     * @param int|null $mPrefectureId
     *
     * @return CustomerL
     */
    public function setMPrefectureId($mPrefectureId = null)
    {
        $this->mPrefectureId = $mPrefectureId;

        return $this;
    }

    /**
     * Get mPrefectureId.
     *
     * @return int|null
     */
    public function getMPrefectureId()
    {
        return $this->mPrefectureId;
    }

    /**
     * Set zipCd.
     *
     * @param string|null $zipCd
     *
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * Set memberRegisterDate.
     *
     * @param \DateTime|null $memberRegisterDate
     *
     * @return CustomerL
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
     * @return CustomerL
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
     * Set createDate.
     *
     * @param \DateTime $createDate
     *
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * @return CustomerL
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
     * Set customer.
     *
     * @param \Project\Customer\Entity\Customer|null $customer
     *
     * @return CustomerL
     */
    public function setCustomer(\Project\Customer\Entity\Customer $customer = null)
    {
        $this->Customer = $customer;

        return $this;
    }

    /**
     * Get customer.
     *
     * @return \Project\Customer\Entity\Customer|null
     */
    public function getCustomer()
    {
        return $this->Customer;
    }
}
