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

namespace Project\Permission\Admin\View\ViewModel\Role;

use Std\ViewModel\FormViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\Permission\Admin\Fieldset\RoleRegisterFieldset;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;

/**
 * Class RegisterViewModel
 *
 * @category ViewModel
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterViewModel extends FormViewModel
{
    protected $template = '/template/role/register.twig';
    protected $confirmTemplate = null;
    protected $finishTemplate = null;

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

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
    ];

    protected $fieldset = [
        RoleRegisterFieldset::class
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
        $form->submit->setValue('登録する');
        if (!$form->isConfirmed()) {
            $form->submit->setValue('確認する');
        }
    }
}
