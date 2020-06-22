<?php
declare(strict_types=1);

namespace Project\Base\Admin\Controller;

use Std\Controller\AbstractController;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;

class AbstractAdminController extends AbstractController implements
    HttpMessageManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
}
