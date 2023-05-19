<?php

namespace Project\Permission\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdminRoleR
 *
 * @ORM\Table(name="r_admin_roles", indexes={@ORM\Index(name="fk_m_admin_id", columns={"m_admin_id"}), @ORM\Index(name="fk_m_role_id", columns={"m_role_id"})})
 * @ORM\Entity
 */
class AdminRoleR extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="r_admin_role_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="R管理者ロールID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $adminRoleRId;

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
     * @var \Project\Permission\Entity\Role
     *
     * @ORM\ManyToOne(targetEntity="Project\Permission\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="m_role_id", referencedColumnName="m_role_id")
     * })
     */
    private $Role;


    /**
     * Get adminRoleRId.
     *
     * @return int
     */
    public function getAdminRoleRId()
    {
        return $this->adminRoleRId;
    }

    /**
     * Set admin.
     *
     * @param \Project\AdminUser\Entity\Admin|null $admin
     *
     * @return AdminRoleR
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

    /**
     * Set role.
     *
     * @param \Project\Permission\Entity\Role|null $role
     *
     * @return AdminRoleR
     */
    public function setRole(\Project\Permission\Entity\Role $role = null)
    {
        $this->Role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return \Project\Permission\Entity\Role|null
     */
    public function getRole()
    {
        return $this->Role;
    }
}
