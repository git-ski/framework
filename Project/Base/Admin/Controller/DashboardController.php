<?php
declare(strict_types=1);
namespace Project\Base\Admin\Controller;

use Std\ViewModel\ViewModelManager;
use Project\Base\Admin\View\ViewModel\DashboardViewModel;
use Std\CacheManager\CacheManagerAwareInterface;
use Project\Base\Admin\Controller\AbstractAdminController;
use Std\SessionManager\SessionManagerAwareInterface;

class DashboardController extends AbstractAdminController implements
    SessionManagerAwareInterface,
    CacheManagerAwareInterface
{
    use \Std\CacheManager\CacheManagerAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;

    public function index()
    {
        return $this->getViewModelManager()->getViewModel([
            "viewModel" => DashboardViewModel::class,
        ]);
    }

    public static function getPageInfo()
    {
        return [
            "title"             => "Dashboard", // title
            "description"       => "Dashboard",
            "site_name"         => "gitski framework", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "theme-light-blue",
            "priority"          => 0,
            "menu"              => true,
            "icon"              => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>'
        ];
    }
}
