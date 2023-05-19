<?php
/**
 * PHP version 7
 * File ConfigurationModel.php
 *
 * @category Model
 * @package  Project\AdminUser\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Permission\Admin\Controller\Permission;

use Std\EntityManager\EntityInterface;
use Project\Permission\Model\RoleResourceModel;
use Project\Permission\Entity\RoleResource;
use Project\Permission\Model\RoleModel;
use Project\Permission\Model\AdminAclModel;
use Std\AclManager\AclManagerAwareInterface;

/**
 * Class ConfigurationModel
 *
 * @category Model
 * @package  Project\AdminUser\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ConfigurationModel extends RoleResourceModel implements
    AclManagerAwareInterface
{
    use \Std\AclManager\AclManagerAwareTrait;

    public function getMatrix(): array
    {
        $AclManager = $this->getAclManager();
        $RolesList = $this->getRoles();
        // まずは、リソース一覧と、ロール一覧でマトリックスを作成
        $matrix = array_fill_keys(array_keys($RolesList), []);
        foreach ($AclManager->getResourcePrivilegeFixed() as $ResourcePrivilege) {
            [
                'defaultAllow'  => $defaultAllow,
                'permission'    => $permission,
            ] = $ResourcePrivilege;
            foreach ($RolesList as $roleId => $role) {
                $matrix[$roleId][$permission] = $defaultAllow;
            }
        }
        // そして、DBに保存しているmatrixを反映していく
        $RoleResources = $this->getRepository()->findAll();
        $RoleResourcesList = array_fill_keys(array_keys($RolesList), []);
        foreach ($RoleResources as $RoleResource) {
            $roleId = $RoleResource->getRole()->getRoleId();
            if (!isset($RoleResourcesList[$roleId])) {
                continue;
            }
            $RoleResourcesList[$roleId][] = $RoleResource;
        }

        foreach ($RoleResourcesList as $roleId => $RoleResources) {
            foreach ($RoleResources as $RoleResource) {
                $resource   = $RoleResource->getResource();
                $privilege  = $RoleResource->getPrivilege();
                $permission = $this->getAclManager()->formatPermission($resource, $privilege);
                $matrix[$roleId][$permission] = $RoleResource->getGrantableFlag();
            }
        }
        return $matrix;
    }

    public function getRoles() : array
    {
        $RoleModel = $this->getObjectManager()->create(RoleModel::class);
        $roleList = [];
        foreach ($RoleModel->getList() as $Role) {
            $roleList[$Role->getRoleId()] = $Role->getRole();
        }
        return $roleList;
    }

    public function updateMatrix($newMatrix)
    {
        $matrix = $this->getMatrix();
        // マトリックスを更新
        foreach ($matrix as $role => $permissionList) {
            foreach ($permissionList as $permission => $defaultGranted) {
                $matrix[$role][$permission] = isset($newMatrix[$role][$permission]) ? true : false;
            }
        }
        // 更新したマトリックスをDBに保存する。
        // 旧データを削除して、新たなデータを入れてく
        $this->deleteAll();
        $RoleModel = $this->getObjectManager()->create(RoleModel::class);
        foreach ($RoleModel->getList() as $Role) {
            $Role = $RoleModel->get($Role->getRoleId());
            $this->bulkCreate($this->permissionGenerator($matrix, $Role), 5000);
        }
    }

    public function permissionGenerator($matrix, $Role)
    {
        $AclManager = $this->getAclManager();
        $aclPermissionList = array_column($AclManager->getResourcePrivilegeFixed()->toArray(), null, 'permission');
        $permissionList = $matrix[$Role->getRoleId()] ?? [];
        foreach ($permissionList as $permission => $isGranted) {
            if (isset($aclPermissionList[$permission])) {
                [
                    'name'      => $name,
                    'resource'  => $resource,
                    'privilege' => $privilege,
                    'group'     => $group
                ] = $aclPermissionList[$permission];
                yield [
                    'Role'          => $Role,
                    'name'          => $name,
                    'resource'      => $resource,
                    'privilege'     => $privilege ?? '',
                    'resourceGroup' => $group,
                    'grantableFlag' => $isGranted
                ];
            }
        }
    }

    public function deleteAll()
    {
        $QueryBuilder = $this->getRepository()->createQueryBuilder('rr');
        $QueryBuilder->delete();
        $QueryBuilder->getQuery()->execute();
    }
}
