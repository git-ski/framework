<?php
declare(strict_types=1);
namespace Std\Renderer;

use Framework\ObjectManager\ObjectManager;

ObjectManager::getSingleton()->export([
    RendererInterface::class => TwigRenderer::class,
]);
