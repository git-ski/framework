<?php
/**
 * PHP version 7
 * File DeleteViewModel.php
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
use Project\AdminUser\Admin\Fieldset\AdminDeleteFieldset;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;

/**
 * Class DeleteViewModel
 *
 * @category ViewModel
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class DeleteViewModel extends FormViewModel
{
    protected $template = '/template/adminUser/delete.twig';
    protected $finishTemplate = '/template/adminUser/delete_finish.twig';

    protected $useConfirm = false;

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
        AdminDeleteFieldset::class
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
        $this->setData($data);
        $form = $this->getForm();
        $form->setData($data);
        $form->submit->setValue('削除する');
        $form->submit->addClass('btn btn-block btn-danger');
        $form->setAttr('class', 'form-horizontal');
    }
}
