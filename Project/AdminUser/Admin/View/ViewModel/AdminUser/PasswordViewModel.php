<?php
/**
 * PHP version 7
 * File PasswordViewModel.php
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
use Project\AdminUser\Admin\Fieldset\AdminPasswordFieldset;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;

/**
 * Class PasswordViewModel
 *
 * @category ViewModel
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class PasswordViewModel extends FormViewModel
{
    protected $template = '/template/adminUser/password.twig';
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

    protected $fieldset = [
        AdminPasswordFieldset::class
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
        $data = $this->getData();
        $data['admin'] = $data['admin']->toArray();
        $form = $this->getForm();
        $form->setData($data);
        $form->submit->addClass('btn btn-block bg-deep-orange');
        $form->submit->setValue('変更する');
    }
}
