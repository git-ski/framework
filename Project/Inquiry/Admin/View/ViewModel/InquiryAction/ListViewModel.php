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

namespace Project\Inquiry\Admin\View\ViewModel\InquiryAction;

use Std\ViewModel\FormViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\Inquiry\Admin\Fieldset\InquiryActionListFieldset;
use Project\Viewpack\Material\ViewModel\PaginatorViewModel;
use Project\Inquiry\Admin\Controller\InquiryAction\ListController;
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
    protected $template = '/template/inquiryAction/list.twig';

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
        InquiryActionListFieldset::class
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
            'paginator' => $data['inquiryAction']->getPages(),
        ]);

        $form = $this->getForm();
        $form->submit->setValue('検索');
        if (isset($data['keyword'])) {
            $form->inquiryAction->keyword->setValue($data['keyword']);
        }
        $items = [];
        foreach ($data['inquiryAction'] as $InquiryAction) {
            $items[] = $InquiryAction->toArray();
        }

        $data['inquiryAction'] = $items;
        $this->setData($data);
    }
}
