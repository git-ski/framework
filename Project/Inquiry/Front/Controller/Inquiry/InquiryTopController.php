<?php
/**
 * PHP version 7
 * File InquiryTopController.php
 *
 * @category Controller
 * @package  Project\Pages\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Inquiry\Front\Controller\Inquiry;

use Project\Base\Front\Controller\AbstractController;
use Std\ViewModel\ViewModelManager;
use Project\Inquiry\Front\View\ViewModel\Inquiry\InquiryTopViewModel;
use Project\Inquiry\Front\Controller\Inquiry\InquiryTopModel as PagesInquiryTopModel;

/**
 * Class InquiryTopController
 *
 * @category Controller
 * @package  Project\Pages\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class InquiryTopController extends AbstractController
{
    /**
     * Method index
     *
     * @return InquiryTopViewModel
     */
    public function index(): InquiryTopViewModel
    {
        $PagesInquiryTopModel = $this->getObjectManager()->get(PagesInquiryTopModel::class);
        return $this->getViewModelManager()->getViewModel([
            'viewModel' => InquiryTopViewModel::class,
            'data'      => [
                'list' => $PagesInquiryTopModel->getList(),
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
            "description"   => "Inquiry", //
            "title"         => "Inquiry", // title
            "site_name"     => "site_name", // titleの|以降
            "lower_title"   => "Inquiry", // マイページ系の表示タイトル
            "meta_description" => "meta_description", // description
            "meta_keywords" => "meta_keywords", // keywords
            "og_title"      => "og_title", // og:title
            "og_description" => "og_description", // og:description
            "og_site_name"  => "og_site_name", // og:site_name
            "og_type"       => "article", // og:type
            'priority'      => 2,
            'menu'          => true,
            'icon'          => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>',
            'group'         => ' 管理',
            'groupIcon'     => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>',
        ];
    }
}
