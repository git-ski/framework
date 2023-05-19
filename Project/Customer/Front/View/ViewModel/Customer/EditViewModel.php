<?php
/**
 * PHP version 7
 * File EditViewModel.php
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel\Customer;

use Std\ViewModel\FormViewModel;
use Project\Customer\Front\View\Layout\MypageLayout;
use Project\Customer\Front\Controller\Customer\ProfileController;
use Project\Customer\Front\Controller\Customer\EditController;
use Project\Base\Front\View\ViewModel\BreadcrumbViewModel;
use Project\Customer\Front\Fieldset\CustomerEditFieldset;
use DateTime;

/**
 * Class EditViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EditViewModel extends FormViewModel
{
    protected $template = '/template/customer/edit.twig';
    protected $confirmTemplate = '/template/customer/edit_confirm.twig';
    protected $finishTemplate = '/template/customer/edit_finish.twig';

    protected $config = [
        'layout' => MypageLayout::class,
        'scripts' => [
            '/common/js/zipcode_search.js',
        ],
        'styles' => [
        ],
        'container' => [
            'Breadcrumb' => [
                [
                    'viewModel' => BreadcrumbViewModel::class,
                    'data'      => [
                        'breadcrumbs' => [
                            ProfileController::class,
                            EditController::class
                        ]
                    ]
                ]
            ]
        ]
    ];

    protected $fieldset = [
        CustomerEditFieldset::class
    ];

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
        self::TRIGGER_FORMCONFIRM   => 'onConfirm',
    ];

    /**
     * Method onRender
     *
     * @return void
     */
    public function onRender(): void
    {
        $form = $this->getForm();
        $data = $this->getData();
        $Customer = $data['customer'];
        $data['customer'] = $Customer->toArray();
        if (!empty($data['customer']['Prefecture'])) {
            $data['customer']['Prefecture'] = $Customer->getPrefecture()->getPrefectureId();
        }
        $data['customer']['Country'] = $Customer->getCountry()->getCountryId();
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $Customer->getBirthDate() . ' 00:00:00');
        if ($date) {
            $data['customer']['birthDateYear'] = $date->format('Y');
            $data['customer']['birthDateMonth'] = $date->format('m');
            $data['customer']['birthDateDay'] = $date->format('d');
        }
        $form->submit->setValue($this->getTranslator()->translate('Change'));
        $form->reset->setValue($this->getTranslator()->translate('Back'));
        $form->setData($data);
        if (!$form->isConfirmed()) {
            $form->submit->setValue($this->getTranslator()->translate('Confirm'));
            $form->submit->setAttr('class', 'cv-area-button');
        }
    }

    public function onConfirm(): void
    {
        $form = $this->getForm();
        $form->reset->setAttr('class', 'button button-border');
        $form->submit->setAttr('class', 'button button-contact');
    }

    /**
     * Method GetTemplateDir
     *
     * @return string templateDir
     */
    public function getTemplateDir(): string
    {
        return __DIR__ . '/../..';
    }
}
