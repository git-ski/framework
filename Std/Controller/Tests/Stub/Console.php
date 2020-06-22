<?php

namespace Std\Controller\Tests\Stub;

use Std\Controller\AbstractConsole;
use Framework\ObjectManager\ObjectManager;
use Std\ViewModel\ViewModelInterface;

class Console extends AbstractConsole
{
    public function index(): void
    {
    }

    public function getHelp()
    {
        return 'help';
    }
}
