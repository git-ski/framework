<?php
/**
 * PHP version 7
 * File Rbac.php
 *
 * @category AclManager
 * @package  Std\AclManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\AclManager;

use Laminas\Permissions\Acl\AclInterface;
use Std\AclManager\RbacInterface;
use Std\AclManager\AclManagerAwareInterface;

/**
 * Rbac
 *
 * @category Class
 * @package  Std\AclManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Rbac implements
    RbacInterface,
    AclManagerAwareInterface
{
    use \Std\AclManager\AclManagerAwareTrait;

    private $Acl = null;
    private $roles = [];

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function build(array $rbacMatrix, $forceRebuild = false): RbacInterface
    {
        $Acl = $this->getAcl();
        // aclが存在しなければ、あるいは強制的に再構築となる場合
        if (null === $Acl || $forceRebuild) {
            $Acl = $this->getAclManager()->prepareAcl();
            foreach ($rbacMatrix as $role => $resourcePrivilegeList) {
                foreach ($resourcePrivilegeList as [
                    'resource' => $resource,
                    'privilege' => $privilege,
                    'allowed'   => $allowed
                ]) {
                    if (!$allowed) {
                        continue;
                    }
                    $permission = $this->getAclManager()->formatPermission($resource, $privilege);
                    if ($Acl->hasResource($permission)) {
                        $Acl->allow($role, $permission);
                    }
                }
            }
            $this->setAcl($Acl);
        }
        return $this;
    }

    public function setAcl(AclInterface $Acl)
    {
        $this->Acl = $Acl;
    }

    public function getAcl()
    {
        return $this->Acl;
    }

    public function getSerializedAcl()
    {
        return serialize($this->getAcl());
    }

    public function restoreSerializedAcl($serializedAcl)
    {
        $this->setAcl(unserialize($serializedAcl));
    }

    /**
     * 対象リソース特権の権限をチェック
     *
     * @return boolean
     */
    public function isAllowed($resource, $privilege = null) :bool
    {
        $Acl = $this->getAcl();
        if ($Acl === null) {
            return false;
        }
        $isAllowed = false;
        $permission = $this->getAclManager()->formatPermission($resource, $privilege);
        if (!$Acl->hasResource($permission)) {
            return false;
        }

        foreach ($this->getRoles() as $role) {
            if ($isAllowed = $Acl->isAllowed($role, $permission)) {
                break;
            }
        }
        return $isAllowed;
    }
}
