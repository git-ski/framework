<?php
/**
 * PHP version 7
 * File ConfigurationViewModel.php
 *
 * @category ViewModel
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\AdminUser\Admin\View\ViewModel\Configuration;

use Std\ViewModel\FormViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\AdminUser\Admin\Fieldset\ConfigurationFieldset;
use Project\AdminUser\Admin\Controller\Configuration\ConfigurationController;
use Project\Base\Front\View\ViewModel\BreadcrumbViewModel;

/**
 * Class ConfigurationViewModel
 *
 * @category ViewModel
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ConfigurationViewModel extends FormViewModel
{
    protected $template = '/template/configuration/configuration.twig';

    protected $config = [
        'layout' => AdminPageLayout::class,
        'scripts' => [
        ],
        'styles' => [
        ],
        'container' => [
        ]
    ];

    protected $fieldset = [
        ConfigurationFieldset::class
    ];

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
    ];

    /**
     * Method GetTemplateDir
     *
     * @return string templateDir
     */
    public function getTemplateDir(): string
    {
        return __DIR__ . '/../..';
    }

    /**
     * Method onRender
     *
     * @return void
     */
    public function onRender(): void
    {

        $form = $this->getForm();
        $form->submit->addClass('btn btn-block bg-deep-orange');
    }
}
