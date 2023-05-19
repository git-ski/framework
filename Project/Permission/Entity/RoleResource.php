<?php

namespace Project\Permission\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoleResource
 *
 * @ORM\Table(name="t_role_resources", indexes={@ORM\Index(name="k_group", columns={"resource_group"}), @ORM\Index(name="fk_m_role_id", columns={"m_role_id"})})
 * @ORM\Entity
 */
class RoleResource extends \Std\EntityManager\AbstractEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="t_role_resource_id", type="integer", nullable=false, options={"unsigned"=true,"comment"="TロールリソースID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $roleResourceId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=false, options={"comment"="リソース特権名"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="resource", type="string", length=64, nullable=false, options={"comment"="リソース"})
     */
    private $resource;

    /**
     * @var string
     *
     * @ORM\Column(name="privilege", type="string", length=64, nullable=false, options={"comment"="特権"})
     */
    private $privilege;

    /**
     * @var string
     *
     * @ORM\Column(name="resource_group", type="string", length=16, nullable=false, options={"comment"="リソースグループ"})
     */
    private $resourceGroup;

    /**
     * @var int
     *
     * @ORM\Column(name="grantable_flag", type="integer", nullable=false, options={"comment"="許可フラグ [0:許可しない 1:許可する]"})
     */
    private $grantableFlag;

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
     * Get roleResourceId.
     *
     * @return int
     */
    public function getRoleResourceId()
    {
        return $this->roleResourceId;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return RoleResource
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
     * Set resource.
     *
     * @param string $resource
     *
     * @return RoleResource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource.
     *
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set privilege.
     *
     * @param string $privilege
     *
     * @return RoleResource
     */
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;

        return $this;
    }

    /**
     * Get privilege.
     *
     * @return string
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * Set resourceGroup.
     *
     * @param string $resourceGroup
     *
     * @return RoleResource
     */
    public function setResourceGroup($resourceGroup)
    {
        $this->resourceGroup = $resourceGroup;

        return $this;
    }

    /**
     * Get resourceGroup.
     *
     * @return string
     */
    public function getResourceGroup()
    {
        return $this->resourceGroup;
    }

    /**
     * Set grantableFlag.
     *
     * @param int $grantableFlag
     *
     * @return RoleResource
     */
    public function setGrantableFlag($grantableFlag)
    {
        $this->grantableFlag = $grantableFlag;

        return $this;
    }

    /**
     * Get grantableFlag.
     *
     * @return int
     */
    public function getGrantableFlag()
    {
        return $this->grantableFlag;
    }

    /**
     * Set role.
     *
     * @param \Project\Permission\Entity\Role|null $role
     *
     * @return RoleResource
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
