<?php
/**
 * PHP version 7
 * File RegisterViewModel.php
 *
 * @category ViewModel
 * @package  Project\Inquiry\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Inquiry\Admin\View\ViewModel\InquiryType;

use Std\ViewModel\FormViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\Inquiry\Admin\Fieldset\InquiryTypeRegisterFieldset;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;

/**
 * Class RegisterViewModel
 *
 * @category ViewModel
 * @package  Project\Inquiry\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterViewModel extends FormViewModel
{
    protected $template = '/template/inquiryType/register.twig';
    protected $confirmTemplate = '/template/inquiryType/register.twig';
    protected $finishTemplate = null;

    protected $config = [
        'layout' => AdminPageLayout::class,
        'scripts' => [
        ],
        'styles' => [
        ],
        'container' => [
            'Breadcrumb' => [
                [
                    'viewModel' => BreadcrumbViewModel::class,
                ]
            ],
        ],
    ];

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
    ];

    protected $fieldset = [
        InquiryTypeRegisterFieldset::class
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
