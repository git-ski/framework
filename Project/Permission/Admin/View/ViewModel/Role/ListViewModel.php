<?php
/**
 * PHP version 7
 * File ListViewModel.php
 *
 * @category ViewModel
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Permission\Admin\View\ViewModel\Role;

use Std\ViewModel\FormViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\Permission\Admin\Fieldset\RoleListFieldset;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;
use Project\Viewpack\Material\ViewModel\PaginatorViewModel;
use Project\Permission\Admin\Controller\Role\ListController;

/**
 * Class ListViewModel
 *
 * @category ViewModel
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ListViewModel extends FormViewModel
{
    protected $template = '/template/role/list.twig';

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
                ]
            ],
            'Paginator' => [
                [
                    'viewModel' => PaginatorViewModel::class,
                    'PaginatorController' => ListController::class,
                ]
            ],
        ]
    ];

    protected $fieldset = [
        RoleListFieldset::class
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
            'paginator' => $data['role']->getPages(),
        ]);

        $this->setData($data);
    }
}
