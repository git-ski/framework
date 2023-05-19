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

namespace Project\Permission\Admin\View\ViewModel\Group\SubForm;

use Std\ViewModel\SubFormViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\Permission\Admin\Fieldset\AdminGroupFieldset;

/**
 * Class RegisterViewModel
 *
 * @category ViewModel
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class AdminGroupViewModel extends SubFormViewModel
{
    protected $template = '/template/group/subform/admin_group.twig';
    protected $confirmTemplate = null;
    protected $finishTemplate = null;

    protected $fieldset = [
        AdminGroupFieldset::class
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
