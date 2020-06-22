<?php
/**
 * PHP version 7
 * File Std\AclManager.php
 *
 * @category AclManager
 * @package  Std\AclManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\AclManager;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Laminas\Permissions\Acl\AclInterface;
use Laminas\Permissions\Acl\Acl;
use Laminas\Permissions\Acl\Role\GenericRole as Role;
use Laminas\Permissions\Acl\Resource\GenericResource as Resource;
use SplFixedArray;

/**
 * Class AclManager
 *
 * @category AclManager
 * @package  Std\AclManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class AclManager implements
    AclManagerInterface,
    ObjectManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;

    private $resourcePrivilegeList = [];
    private $roleList = [];
    private $resourcePrivilegeFixed = null;

    /**
     * {@inheritDoc}
     */
    public function registerResourcePrivilege(array $resourcePrivilege, $group): AclManagerInterface
    {
        $resourcePrivilege = array_merge([
            'resource'      => null,
            'privilege'     => null,
            'name'          => null,
            'description'   => null,
            'defaultAllow'  => false
        ], $resourcePrivilege);
        $this->resourcePrivilegeList[$group] = $this->resourcePrivilegeList[$group] ?? [];
        $this->resourcePrivilegeList[$group][] = $resourcePrivilege;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getResourceGroup() : array
    {
        return array_keys($this->resourcePrivilegeList);
    }

    /**
     * {@inheritDoc}
     */
    public function getResourcePrivilegeList() : array
    {
        return $this->resourcePrivilegeList;
    }

    /**
     * {@inheritDoc}
     */
    public function getResourcePrivilegeFixed() : SplFixedArray
    {
        if (null === $this->resourcePrivilegeFixed) {
            $fixedLength = array_reduce($this->resourcePrivilegeList, function ($length, $list) {
                return $length + count($list);
            }, 0);
            $this->resourcePrivilegeFixed = new SplFixedArray($fixedLength);
            $index = 0;
            foreach ($this->resourcePrivilegeList as $group => $resourcePrivilegeList) {
                foreach ($resourcePrivilegeList as $resourcePrivilege) {
                    [
                        'resource'  => $resource,
                        'privilege' => $privilege,
                    ] = $resourcePrivilege;
                    $resourcePrivilege['permission']    = $this->formatPermission($resource, $privilege);
                    $resourcePrivilege['group']     = $group;
                    $this->resourcePrivilegeFixed[$index] = $resourcePrivilege;
                    ++$index;
                }
            }
        }
        return $this->resourcePrivilegeFixed;
    }

    /**
     * {@inheritDoc}
     */
    public function registerRole(string $role): AclManagerInterface
    {
        $this->roleList[$role] = $role;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoleList(): array
    {
        return $this->roleList;
    }

    public function prepareAcl(): Acl
    {
        $Acl = new Acl;
        // AclManager上有効なRoleをセットする
        foreach ($this->getRoleList() as $role) {
            $Acl->addRole(new Role($role));
        }
        // AclManager上有効なリソース特権をセットする。
        foreach ($this->getResourcePrivilegeFixed() as [
            'permission' => $permission
        ]) {
            $Acl->addResource(new Resource($permission));
        }
        return $Acl;
    }

    public function formatPermission($resource, $privilege = null) : string
    {
        return $privilege ? $resource . '_' . $privilege : $resource;
    }
}
