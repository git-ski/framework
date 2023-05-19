<?php
/**
 * PHP version 7
 * File EditViewModel.php
 *
 * @category ViewModel
 * @package  Project\Inquiry\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Inquiry\Admin\View\ViewModel\Inquiry;

use Std\ViewModel\AbstractViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\Inquiry\Admin\Fieldset\InquiryEditFieldset;

/**
 * Class EditViewModel
 *
 * @category ViewModel
 * @package  Project\Inquiry\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EditViewModel extends AbstractViewModel
{
    protected $template = '/template/inquiry/edit.twig';
    protected $confirmTemplate = '/template/inquiry/edit.twig';
    protected $finishTemplate = null;

    protected $fieldset = [
        InquiryEditFieldset::class
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
        $data['inquiry'] = $data['inquiry']->toArray();
        $data['inquiry']['InquiryType'] = $data['inquiry']['InquiryType']->getInquiryTypeId();
        $data['inquiry']['InquiryAction'] = $data['inquiry']['InquiryAction']->getInquiryActionId();

        $form = $this->getForm();
        $form->submit->addClass('btn btn-block bg-deep-orange');
        $form->submit->setValue('編集する');
        if (!$form->isConfirmed()) {
            $form->submit->setValue('確認する');
        }

        $form->setData($data);
    }
}
