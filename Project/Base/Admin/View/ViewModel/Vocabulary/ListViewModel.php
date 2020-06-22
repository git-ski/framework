<?php
/**
 * PHP version 7
 * File ListViewModel.php
 *
 * @category ViewModel
 * @package  Project\Base\Admin
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Admin\View\ViewModel\Vocabulary;

use Std\ViewModel\FormViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\Base\Admin\Fieldset\VocabularyHeaderListFieldset;
use Project\Viewpack\Material\ViewModel\PaginatorViewModel;
use Project\Base\Admin\Controller\Vocabulary\ListController;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;

/**
 * Class ListViewModel
 *
 * @category ViewModel
 * @package  Project\Base\Admin
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class ListViewModel extends FormViewModel
{
    protected $template = '/template/vocabulary/list.twig';

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
        VocabularyHeaderListFieldset::class
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
            'paginator' => $data['vocabularyHeader']->getPages(),
        ]);

        $form = $this->getForm();
        $form->submit->setValue('検索');
        if (isset($data['keyword'])) {
            $form->vocabularyHeader->keyword->setValue($data['keyword']);
        }
        $items = [];
        foreach ($data['vocabularyHeader'] as $VocabularyHeader) {
            $items[] = $VocabularyHeader->toArray();
        }

        $data['vocabularyHeader'] = $items;
        $this->setData($data);
    }
}
