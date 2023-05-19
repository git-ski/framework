<?php
/**
 * PHP version 7
 * File LoginViewModel.php
 *
 * @category ViewModel
 * @package  Project\Base\AdminUser
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\AdminUser\Admin\View\ViewModel;

use Std\ViewModel\FormViewModel;
use Project\AdminUser\Admin\View\Layout\AdminLoginPageLayout;
use Project\AdminUser\Admin\Fieldset\AdminLoginFieldset;

/**
 * Class LoginViewModel
 *
 * @category LoginViewModel
 * @package  Project\Base\AdminUser
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class LoginViewModel extends FormViewModel
{
    protected $template = '/template/login.twig';

    protected $config = [
        'layout' => AdminLoginPageLayout::class,
        'scripts' => [
        ]
    ];

    protected $fieldset = [
        AdminLoginFieldset::class
    ];

    /**
     * Method GetTemplateDir
     *
     * @return string templateDir
     */
    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
