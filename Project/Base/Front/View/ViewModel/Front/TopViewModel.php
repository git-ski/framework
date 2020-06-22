<?php
/**
 * PHP version 7
 * File TopViewModel.php
 *
 * @category ViewModel
 * @package  Project\Base\Front
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Front\View\ViewModel\Front;

use Std\ViewModel\AbstractViewModel;
use Project\Base\Front\View\Layout\FrontPageLayout;
use Project\Base\Front\Fieldset\TopFieldset;
use Project\Base\Front\Controller\Front\TopController;
use Project\Base\Front\View\ViewModel\BreadcrumbViewModel;

/**
 * Class TopViewModel
 *
 * @category ViewModel
 * @package  Project\Base\Front
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class TopViewModel extends AbstractViewModel
{
  protected $template = '/template/front/index.twig';

    protected $config = [
        'layout' => FrontPageLayout::class,
        'scripts' => [
        ],
        'styles' => [
        ],
        'container' => [
        ]
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
        // ここで拡張
        $data = $this->getData();
        $rows = [];
        $row  = [];
        foreach ($data['list'] as $index => $Item) {
            if ($index && $index % 3 === 0) {
                $rows[] = $row;
                $row = [];
            }
            $row[] = $Item;
        }
        $rows[] = $row;
        $data['rows'] = $rows;
        $this->setData($data);
    }
}
