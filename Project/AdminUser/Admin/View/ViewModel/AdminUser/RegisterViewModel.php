<?php
/**
 * PHP version 7
 * File RegisterViewModel.php
 *
 * @category ViewModel
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\AdminUser\Admin\View\ViewModel\AdminUser;

use Std\ViewModel\FormViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\AdminUser\Admin\Fieldset\AdminRegisterFieldset;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;

/**
 * Class RegisterViewModel
 *
 * @category ViewModel
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterViewModel extends FormViewModel
{
    protected $template = '/template/adminUser/register.twig';
    protected $confirmTemplate = null;
    protected $finishTemplate = '/template/adminUser/register_finish.twig';

    protected $config = [
        'layout' => AdminPageLayout::class,
        'container' => [
            'Breadcrumb' => [
                [
                    'viewModel' => BreadcrumbViewModel::class,
                ]
            ],
        ]
    ];

    protected $fieldset = [
        AdminRegisterFieldset::class
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

    public function onRender(): void
    {
        $form = $this->getForm();
        $form->submit->addClass('btn btn-block bg-deep-orange');
        $form->submit->setValue('登録する');
        if (!$form->isConfirmed()) {
            $form->submit->setValue('確認する');
        }
    }
}
