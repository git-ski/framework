<?php
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel\Authentication;

use Std\ViewModel\AbstractViewModel;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;

class AuthenticatedViewModel extends AbstractViewModel
{
    protected $template = '/template/authencation/authenticated.twig';

    public function getRenderer() : RendererInterface
    {
        return $this->getObjectManager()->get(TwigRenderer::class);
    }

    public function getTemplateDir()
    {
        return __DIR__ . '/../..';
    }
}
