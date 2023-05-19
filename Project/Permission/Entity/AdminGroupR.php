<?php

namespace Project\Permission\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdminGroupR
 *
 * @ORM\Table(name="r_admin_groups", indexes={@ORM\Index(name="fk_m_admin_id", columns={"m_admin_id"}), @ORM\Index(name="idx_group_id", columns={"group_id"})})
 * @ORM\Entity
 */
class AdminGroupR extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="r_admin_group_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="R管理者グループID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $adminGroupRId;

    /**
     * @var int
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="グループID"})
     */
    private $groupId;

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
     * Get adminGroupRId.
     *
     * @return int
     */
    public function getAdminGroupRId()
    {
        return $this->adminGroupRId;
    }

    /**
     * Set groupId.
     *
     * @param int $groupId
     *
     * @return AdminGroupR
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * Get groupId.
     *
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set admin.
     *
     * @param \Project\AdminUser\Entity\Admin|null $admin
     *
     * @return AdminGroupR
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
