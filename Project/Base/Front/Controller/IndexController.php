<?php
declare(strict_types=1);

namespace Project\Base\Front\Controller;

use Std\ViewModel\ViewModelManager;
use Project\Base\Front\View\ViewModel\IndexViewModel;

class IndexController extends AbstractController
{
    public function index()
    {
        return $this->getViewModelManager()->getViewModel([
            "viewModel" => IndexViewModel::class,
        ]);
    }
}
