<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Permission\Admin\Controller\Role;

use Std\EntityManager\EntityInterface;
use Project\Permission\Model\RoleModel;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class DeleteModel extends RoleModel
{
    public function delete($idOrRole) : EntityInterface
    {


        return parent::delete($idOrRole);
    }
}
