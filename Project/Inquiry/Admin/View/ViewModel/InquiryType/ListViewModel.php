<?php
/**
 * PHP version 7
 * File ListViewModel.php
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
use Project\Inquiry\Admin\Fieldset\InquiryTypeListFieldset;
use Project\Viewpack\Material\ViewModel\PaginatorViewModel;
use Project\Inquiry\Admin\Controller\InquiryType\ListController;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;

/**
 * Class ListViewModel
 *
 * @category ViewModel
 * @package  Project\Inquiry\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ListViewModel extends FormViewModel
{
    protected $template = '/template/inquiryType/list.twig';

    protected $config = [
        'layout' => AdminPageLayout::class,
        'scripts' => [
            "/material/plugins/jquery-datatable/jquery.dataTables.js",
            "/material/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js",
            '/admin/js/list.js',
        ],
        'styles' => [
            "/material/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css",
        ],
        'container' => [
            'Paginator' => [
                [
                    'viewModel' => PaginatorViewModel::class,
                    'PaginatorController' => ListController::class
                ]
            ],
            'Breadcrumb' => [
                [
                    'viewModel' => BreadcrumbViewModel::class,
                ]
            ],
        ]
    ];

    protected $fieldset = [
        InquiryTypeListFieldset::class
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

        $PaginatorViewModel = $this->getContainer('Paginator')->get(PaginatorViewModel::class);
        $PaginatorViewModel->setData([
            'paginator' => $data['inquiryType']->getPages(),
        ]);

        $form = $this->getForm();
        $form->submit->setValue('検索');
        if (isset($data['keyword'])) {
            $form->inquiryType->keyword->setValue($data['keyword']);
        }
        $items = [];
        foreach ($data['inquiryType'] as $InquiryType) {
            $items[] = $InquiryType->toArray();
        }

        $data['inquiryType'] = $items;
        $this->setData($data);
    }
}
