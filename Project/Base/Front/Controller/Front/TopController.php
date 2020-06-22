<?php
/**
 * PHP version 7
 * File TopController.php
 *
 * @category Controller
 * @package  Project\Base\Front
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Front\Controller\Front;

use Project\Base\Front\Controller\AbstractController;
use Std\ViewModel\ViewModelManager;
use Project\Base\Front\View\ViewModel\Front\TopViewModel;
use Project\Base\Front\Controller\Front\TopModel as FrontTopModel;

/**
 * Class TopController
 *
 * @category Controller
 * @package  Project\Base\Front
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class TopController extends AbstractController
{
    /**
     * Method index
     *
     * @return TopViewModel
     */
    public function index(): TopViewModel
    {
        $FrontTopModel = $this->getObjectManager()->get(FrontTopModel::class);
        return $this->getViewModelManager()->getViewModel([
            'viewModel' => TopViewModel::class,
            'data'      => [
                'list' => $FrontTopModel->getList(),
            ],
        ]);
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "description"   => "description",
            "title"         => "title",
            "site_name"     => "site_name",
            "lower_title"   => "lower_title",
            "meta_description" => "meta_description",
            "meta_keywords" => "meta_keywords",
            "og_title"      => "og_title",
            "og_description" => "og_description",
            "og_site_name"  => "og_site_name",
            "og_type"       => "og_type",
            'menu'          => true,
            'icon'          => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>',
            'group'         => ' 管理',
            'groupIcon'     => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>',
        ];
    }
}
