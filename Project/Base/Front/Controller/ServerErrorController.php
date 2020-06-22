<?php
declare(strict_types=1);

namespace Project\Base\Front\Controller;

use Std\ViewModel\ViewModelManager;
use Project\Base\Front\View\ViewModel\ServerErrorViewModel;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;

class ServerErrorController extends AbstractController implements
    HttpMessageManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;

    public function index()
    {
        $Response = $this->getHttpMessageManager()->getResponse();
        $this->getHttpMessageManager()->setResponse($Response->withStatus(500));
        return $this->getViewModelManager()->getViewModel([
            "viewModel" => ServerErrorViewModel::class,
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
            "description" => "500 internal server error", //
            "title" => "500 internal server error", // title
            "site_name" => "site_name", // titleの|以降
            "lower_title" => "500 internal server error", // マイページ系の表示タイトル
            "meta_description" => "meta_description", // description
            "meta_keywords" => "meta_keywords", // keywords
            "og_title" => "og_title", // og:title
            "og_description" => "og_description", // og:description
            "og_site_name" => "og_site_name", // og:site_name
            "og_type" => "article", // og:type
            "priority" => 0,
            "menu" => false,
        ];
    }
}
