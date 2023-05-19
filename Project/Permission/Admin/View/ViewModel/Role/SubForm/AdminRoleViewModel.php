<?php
/**
 * PHP version 7
 * File RegisterViewModel.php
 *
 * @category ViewModel
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Permission\Admin\View\ViewModel\Role\SubForm;

use Std\ViewModel\SubFormViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\Permission\Admin\Fieldset\AdminRoleFieldset;

/**
 * Class RegisterViewModel
 *
 * @category ViewModel
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class AdminRoleViewModel extends SubFormViewModel
{
    protected $template = '/template/role/subform/admin_role.twig';
    protected $confirmTemplate = '/template/role/subform/admin_role.twig';
    protected $finishTemplate = null;

    protected $fieldset = [
        AdminRoleFieldset::class
    ];

    /**
     * Method GetTemplateDir
     *
     * @return string templateDir
     */
    public function getTemplateDir(): string
    {
        return __DIR__ . '/../../../';
    }
}
