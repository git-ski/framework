<?php

namespace Std\Controller\Tests\Stub;

use Std\Controller\AbstractController;
use Framework\ObjectManager\ObjectManager;
use Std\ViewModel\ViewModelInterface;

class Controller extends AbstractController
{
    public function index(): ViewModelInterface
    {
        return ObjectManager::getSingleton()->get(ViewModelInterface::class);
    }
}
