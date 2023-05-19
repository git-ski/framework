<?php
/**
 * PHP version 7
 * File DeleteViewModel.php
 *
 * @category ViewModel
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Admin\View\ViewModel\Customer;

use Std\ViewModel\FormViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\Customer\Admin\Fieldset\CustomerDeleteFieldset;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;
use Project\Customer\Model\CustomerModel;
use Project\Base\Helper\VocabularyHelper;

/**
 * Class DeleteViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class DeleteViewModel extends FormViewModel
{
    protected $template = '/template/customer/delete.twig';
    protected $finishTemplate = null;

    protected $useConfirm = false;

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

    protected $fieldset = [
        CustomerDeleteFieldset::class
    ];


    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
    ];

    public function getRenderer() : RendererInterface
    {
        return $this->getObjectManager()->get(TwigRenderer::class);
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

    /**
     * Method onRender
     *
     * @return void
     */
    public function onRender(): void
    {
        $data = $this->getData();
        $data['customer'] = $data['customer']->toArray();
        $this->setData($this->convert($data));
        $form = $this->getForm();
        $form->setData($this->convert($data));
        $form->submit->setValue('削除する');
        $form->submit->addClass('btn btn-block btn-danger');
        $form->setAttr('class', 'form-horizontal');
    }

    private function convert($data) {
        $VocabularyHelper = $this->getObjectManager()->get(VocabularyHelper::class);
        $data['customer']['mailmagazineReceiveFlag'] = CustomerModel::getPropertyValueLabel('mailmagazineReceiveFlag', $data['customer']['mailmagazineReceiveFlag']);
        $data['customer']['sexTypeId'] = $VocabularyHelper->getName($data['customer']['sexTypeId']);
        return $data;
    }
}
