<?php
/**
 * PHP version 7
 * File AclManagerInterface.php
 *
 * @category AclManager
 * @package  Std\AclManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\AclManager;

use Laminas\Permissions\Acl\Acl;
use SplFixedArray;

/**
 * Interface AclManager
 *
 * @category Interface
 * @package  Std\AclManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface AclManagerInterface
{
    /**
     * リソース特権情報を登録する
     * リソース特権情報は下記の形式になる
     * [
     *     'resource'      => ...,
     *     'privilege'     => ...,
     *     'name'          => ...,
     *     'description'   => ...,
     *     'defaultAllow'  => ...,
     * ]
     * リソース特権情報はそれぞれのグループと紐づいてる状態で維持する
     *
     * @param array $resourcePrivilege
     * @param string $group
     * @return AclManagerInterface
     */
    public function registerResourcePrivilege(array $resourcePrivilege, $group): AclManagerInterface;

    /**
     * Roleを登録する
     * ※DBに登録するのではなく
     * DBなどに保存しているRole情報をAclManagerの中にセットするためのメソッド
     * さらに、今ログインしているユーザーが持つRoleではなく、システム上全ての有効なRoleを登録する
     *
     * @param string $role
     * @return AclManagerInterface
     */
    public function registerRole(string $role): AclManagerInterface;

    /**
     * 登録済みのリソース特権情報から、グループ一覧のみを返す
     *
     * @return array
     */
    public function getResourceGroup() : array;

    /**
     * 登録済みのリソース特権情報を扱いやすいように、一階層の配列に直して返す
     *
     * @return SplFixedArray
     */
    public function getResourcePrivilegeFixed() : SplFixedArray;

    /**
     * 登録済みのリソース特権情報を取得
     *
     * @return array
     */
    public function getResourcePrivilegeList() : array;

    /**
     * Aclオブジェクトを初期化する。
     *
     * @return Acl
     */
    public function prepareAcl(): Acl;

    /**
     * resourceとprivilegeを使って、permissionを取得する。
     *
     * @param string $resource
     * @param string $privilege
     * @return string
     */
    public function formatPermission($resource, $privilege = null) : string;
}
