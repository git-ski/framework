<?php
/**
 * PHP version 7
 * File RbacInterface.php
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

/**
 * Interface RbacInterface
 *
 * @category Interface
 * @package  Std\AclManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface RbacInterface
{
    /**
     * Aclオブジェクトを返す
     *
     * @return AclInterface
     */
    public function getAcl();

    /**
     * システム上持っているrbac情報をベースにRbacオブジェクトを再生する。
     *
     * @param array $rbacMatrix
     * @param boolean $forceRebuild
     * @return RbacInterface
     */
    public function build(array $rbacMatrix, $forceRebuild = false): RbacInterface;

    /**
     * 対象リソース特権の権限をチェック
     *
     * @return bool
     */
    public function isAllowed($resource, $privilege = null) :bool;
}
