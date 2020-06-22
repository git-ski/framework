<?php
/**
 * PHP version 7
 * File DeleteViewModel.php
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
use Project\Base\Admin\Fieldset\VocabularyHeaderDeleteFieldset;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;

/**
 * Class DeleteViewModel
 *
 * @category ViewModel
 * @package  Project\Base\Admin
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class DeleteViewModel extends FormViewModel
{
    protected $template = '/template/vocabulary/delete.twig';
    protected $finishTemplate = '/template/vocabulary/delete_finish.twig';

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
        VocabularyHeaderDeleteFieldset::class
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
        $data['vocabularyHeader'] = $data['vocabularyHeader']->toArray();
        $this->setData($data);
        $form = $this->getForm();
        $form->setData($data);
        $form->submit->setValue('削除する');
        $form->submit->addClass('btn btn-block btn-danger');
        $form->setAttr('class', 'form-horizontal');
    }
}
