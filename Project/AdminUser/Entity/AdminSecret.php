<?php

namespace Project\AdminUser\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdminSecret
 *
 * @ORM\Table(name="t_admin_secrets", indexes={@ORM\Index(name="fk_m_admin_id", columns={"m_admin_id"}), @ORM\Index(name="vendor", columns={"m_admin_id", "code"})})
 * @ORM\Entity
 */
class AdminSecret extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="t_admin_secret_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="T管理者秘密鍵ID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $adminSecretId;

    /**
     * @var string
     *
     * @ORM\Column(name="secret", type="string", length=64, nullable=false, options={"comment"="MロールID"})
     */
    private $secret;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=16, nullable=false, options={"comment"="使用者コード"})
     */
    private $code;

    /**
     * @var \Project\AdminUser\Entity\Admin
     *
     * @ORM\ManyToOne(targetEntity="Project\AdminUser\Entity\Admin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="m_admin_id", referencedColumnName="m_admin_id")
     * })
     */
    private $Admin;


    /**
     * Get adminSecretId.
     *
     * @return int
     */
    public function getAdminSecretId()
    {
        return $this->adminSecretId;
    }

    /**
     * Set secret.
     *
     * @param string $secret
     *
     * @return AdminSecret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * Get secret.
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return AdminSecret
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set admin.
     *
     * @param \Project\AdminUser\Entity\Admin|null $admin
     *
     * @return AdminSecret
     */
    public function setAdmin(\Project\AdminUser\Entity\Admin $admin = null)
    {
        $this->Admin = $admin;

        return $this;
    }

    /**
     * Get admin.
     *
     * @return \Project\AdminUser\Entity\Admin|null
     */
    public function getAdmin()
    {
        return $this->Admin;
    }
}
