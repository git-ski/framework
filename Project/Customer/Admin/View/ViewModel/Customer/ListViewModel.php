<?php
/**
 * PHP version 7
 * File ListViewModel.php
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
use Project\Customer\Admin\Fieldset\CustomerListFieldset;
use Project\Viewpack\Material\ViewModel\PaginatorViewModel;
use Project\Customer\Admin\Controller\Customer\ListController;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;

/**
 * Class ListViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ListViewModel extends FormViewModel
{
    protected $template = '/template/customer/list.twig';

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
        CustomerListFieldset::class
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

        $PaginatorViewModel = $this->getContainer('Paginator')->get(PaginatorViewModel::class);
        $PaginatorViewModel->setData([
            'paginator' => $data['customer']->getPages(),
        ]);

        $form = $this->getForm();
        $form->submit->setValue('検索');
        $form->customer->keyword->setValue($data['condition']['keyword'] ?? null);
        $form->setAttr('action', $this->getRouter()->linkto(ListController::class));
        $items = [];
        foreach ($data['customer'] as $Customer) {
            $item = $Customer->toArray();
            if ($item['Prefecture']) {
                $item['Prefecture'] = $item['Prefecture']->getPrefectureName();
            }
            if ($item['Country']) {
                $item['Country'] = $item['Country']->getCountryName();
            }
            $items[] = $item;
        }

        $data['customer'] = $items;
        $this->setData($data);
    }
}
