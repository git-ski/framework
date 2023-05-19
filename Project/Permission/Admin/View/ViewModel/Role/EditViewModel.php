<?php
/**
 * PHP version 7
 * File EditViewModel.php
 *
 * @category ViewModel
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Permission\Admin\View\ViewModel\Role;

use Std\ViewModel\AbstractViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\Permission\Admin\Fieldset\RoleEditFieldset;

/**
 * Class EditViewModel
 *
 * @category ViewModel
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EditViewModel extends RegisterViewModel
{
    protected $template = '/template/role/edit.twig';
    protected $confirmTemplate = null;
    protected $finishTemplate = null;

    protected $fieldset = [
        RoleEditFieldset::class
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
        $data['role'] = $data['role']->toArray();
        $form = $this->getForm();
        $form->setData($data);
        $form->submit->addClass('btn btn-block bg-deep-orange');
        $form->submit->setValue('編集する');
        if (!$form->isConfirmed()) {
            $form->submit->setValue('確認する');
        }
    }
}
