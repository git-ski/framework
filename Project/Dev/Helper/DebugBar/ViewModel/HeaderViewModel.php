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

namespace Project\Dev\Helper\DebugBar\ViewModel;

use Std\ViewModel\AbstractViewModel;

/**
 * Class LoginViewModel
 *
 * @category LoginViewModel
 * @package  Project\Base\AdminUser
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class HeaderViewModel extends AbstractViewModel
{
    protected $template = '/template/header.twig';

    protected $config = [
        'scripts' => [
        ]
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
