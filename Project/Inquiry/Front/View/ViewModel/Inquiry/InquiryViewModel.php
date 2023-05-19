<?php
/**
 * PHP version 7
 * File InquiryViewModel.php
 *
 * @category ViewModel
 * @package  Project\Inquiry\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Inquiry\Front\View\ViewModel\Inquiry;

use Std\ViewModel\FormViewModel;
use Project\Base\Front\View\Layout\FrontPageLayout;
use Project\Inquiry\Front\Fieldset\InquiryFieldset;
use Project\Base\Front\Controller\Front\TopController;
use Project\Inquiry\Front\Controller\Inquiry\InquiryController;
use Project\Base\Front\View\ViewModel\BreadcrumbViewModel;
use Project\Inquiry\Front\View\ViewModel\Inquiry\InquiryStepViewModel;

/**
 * Class InquiryViewModel
 *
 * @category ViewModel
 * @package  Project\Inquiry\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class InquiryViewModel extends FormViewModel
{
    protected $template = '/template/inquiry/inquiry.twig';
    protected $confirmTemplate = '/template/inquiry/inquiry_confirm.twig';
    protected $finishTemplate = '/template/inquiry/inquiry_finish.twig';

    protected $config = [
        'layout' => FrontPageLayout::class,
        'scripts' => [
        ],
        'styles' => [

        ],
        'container' => [
            'Breadcrumb' => [
                [
                    'viewModel' => BreadcrumbViewModel::class,
                    'data'      => [
                        'breadcrumbs' => [
                            TopController::class,
                            InquiryController::class
                        ]
                    ]
                ]
            ],
            'Steps'  => [
                [ 'viewModel' => InquiryStepViewModel::class ],
            ]
        ]
    ];

    protected $fieldset = [
        InquiryFieldset::class
    ];

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
        self::TRIGGER_INITED        => 'onInit',
        self::TRIGGER_FORMCONFIRM   => 'onConfirm',
        self::TRIGGER_FORMFINISH    => 'onFinish',
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
        if (!empty($data['customer'])) {
            $data['inquiry']['name'] = $data['customer']['nameSei'] . $data['customer']['nameMei'];
            $data['inquiry']['email'] = $data['customer']['email'];
            $data['inquiry']['phone'] = $data['customer']['phone'];
        }
        $form = $this->getForm();
        $form->setData($data);
    }

    public function onInit(): void
    {
        $this->getContainer('Steps')->get(InquiryStepViewModel::VIEW_ID)
            ->setStep(InquiryStepViewModel::INQUIRY);
        $form = $this->getForm();
        $form->submit->setValue($this->getTranslator()->translate('Confirm '));
        $form->submit->addClass('cv-area-button');
    }

    public function onConfirm(): void
    {
        $this->getContainer('Steps')->get(InquiryStepViewModel::VIEW_ID)
            ->setStep(InquiryStepViewModel::INQUIRY_CONFIRM);
        $form = $this->getForm();
        $form->submit->setValue($this->getTranslator()->translate('Complete'));
        $form->submit->addClass('cv-area-button');
    }

    public function onFinish(): void
    {
        $this->getContainer('Steps')->get(InquiryStepViewModel::VIEW_ID)
            ->setStep(InquiryStepViewModel::INQUIRY_FINISH);
    }
}
