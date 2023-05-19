<?php

namespace Project\Permission\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdminAcl
 *
 * @ORM\Table(name="t_admin_acls", indexes={@ORM\Index(name="fk_m_admin_id", columns={"m_admin_id"})})
 * @ORM\Entity
 */
class AdminAcl extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="t_admin_acl_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="T管理者権限管理ID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $adminAclId;

    /**
     * @var string
     *
     * @ORM\Column(name="acl", type="blob", length=65535, nullable=false, options={"comment"="access control list"})
     */
    private $acl;

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
     * Get adminAclId.
     *
     * @return int
     */
    public function getAdminAclId()
    {
        return $this->adminAclId;
    }

    /**
     * Set acl.
     *
     * @param string $acl
     *
     * @return AdminAcl
     */
    public function setAcl($acl)
    {
        $this->acl = $acl;

        return $this;
    }

    /**
     * Get acl.
     *
     * @return string
     */
    public function getAcl()
    {
        return $this->acl;
    }

    /**
     * Set admin.
     *
     * @param \Project\AdminUser\Entity\Admin|null $admin
     *
     * @return AdminAcl
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
