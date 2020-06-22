<?php
declare(strict_types=1);

namespace Project\Base\Front\Controller;

use Std\Controller\AbstractController as StdController;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Std\ViewModel\ViewModelInterface;

abstract class AbstractController extends StdController implements
    HttpMessageManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
}
