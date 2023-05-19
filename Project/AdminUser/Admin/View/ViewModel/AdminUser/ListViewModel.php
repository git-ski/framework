<?php
/**
 * PHP version 7
 * File ListViewModel.php
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
use Project\AdminUser\Admin\Fieldset\AdminListFieldset;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;
use Project\Viewpack\Material\ViewModel\PaginatorViewModel;
use Project\AdminUser\Admin\Controller\AdminUser\ListController;

/**
 * Class ListViewModel
 *
 * @category ViewModel
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ListViewModel extends FormViewModel
{
    protected $template = '/template/adminUser/list.twig';

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
            'Breadcrumb' => [
                [
                    'viewModel' => BreadcrumbViewModel::class,
                ],
            ],
            'Paginator' => [
                [
                    'viewModel' => PaginatorViewModel::class,
                    'PaginatorController' => ListController::class
                ]
            ],
        ]
    ];

    protected $fieldset = [
        AdminListFieldset::class
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
        $form = $this->getForm();
        $data = $this->getData();

        $PaginatorViewModel = $this->getContainer('Paginator')->get(PaginatorViewModel::class);
        $PaginatorViewModel->setData([
            'paginator' => $data['admin']->getPages(),
        ]);
        $items = [];
        foreach ($data['admin'] as $admin) {
            $admin = $admin->toArray();
            $items[] = $admin;
        }
        $data['admin'] = $items;

        if (isset($data['search_options'])) {
            $form->admin->keyword->setValue($data['search_options']['keyword']);
        }
        $form->getElement('submit')->setValue('検索');
        $this->setData($data);
    }
}
